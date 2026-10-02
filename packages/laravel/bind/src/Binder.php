<?php

declare(strict_types=1);

namespace Honed\Bind;

use Honed\Bind\Attributes\Binds;
use Illuminate\Container\Container;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use Throwable;

/**
 * @template T of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 */
abstract class Binder
{
    /**
     * The default namespace where binders reside.
     *
     * @var string
     */
    public static $namespace = 'App\\Binders\\';

    /**
     * The name of the binder's corresponding model.
     *
     * @var class-string<T>|null
     */
    protected $model;

    /**
     * The key of the binder to be used when resolving the value of the binding.
     *
     * @var string|null
     */
    protected $key;

    /**
     * Store a memory-cache of the binders to ensure that we don't have to re-instantiate them.
     *
     * @var array<class-string<Model>, array<string, class-string<self>>>|null
     */
    protected static $binders;

    /**
     * The default model name resolvers.
     *
     * @var array<class-string, callable(self): class-string<T>>
     */
    protected static $modelNameResolvers = [];

    /**
     * Retrieve the binder for the model which binds the given field if it exists.
     *
     * @param  class-string<T>  $model
     */
    public static function for(string $model, string $field): ?static
    {
        return static::cached($model, $field);
    }

    /**
     * Get the binder from the Binds class attribute.
     *
     * @return class-string<Model>|null
     */
    public static function getBindsAttribute(): ?string
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(Binds::class);

        if ($attributes !== []) {
            $for = $attributes[0]->newInstance();

            return $for->model;
        }

        return null;
    }

    /**
     * Specify the callback that should be invoked to guess model names based on binder names.
     *
     * @param  callable(self): class-string<T>|null  $callback
     */
    public static function guessModelNamesUsing(?callable $callback): void
    {
        if ($callback === null) {
            unset(static::$modelNameResolvers[static::class]);

            return;
        }

        static::$modelNameResolvers[static::class] = $callback;
    }

    /**
     * Specify the default namespace that contains the application's model binders.
     */
    public static function useNamespace(string $namespace): void
    {
        static::$namespace = $namespace;
    }

    /**
     * Flush the binder's global state.
     */
    public static function flushState(): void
    {
        static::$binders = null;
        static::$modelNameResolvers = [];
        static::$namespace = 'App\\Binders\\';
    }

    /**
     * Resolve the binding for the model.
     *
     * @param  T|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation<T, *, *>  $query
     * @return T|null
     */
    public function resolve(Model|EloquentBuilder $query, mixed $value, string $field): ?Model
    {
        /** @var \Illuminate\Database\Eloquent\Builder<T>|\Illuminate\Database\Eloquent\Relations\Relation<T, *, *> $result */
        $result = $this->query($query, $value, $field);

        /** @var T|null $model */
        $model = $result->first();

        return $model;
    }

    /**
     * Get the field, accounting for qualified column names.
     */
    public function getField(string $field): string
    {
        return Str::afterLast($field, '.');
    }

    /**
     * Resolve the binding query for the model.
     *
     * Constraints are added to the query Laravel already scoped, including global
     * scopes and child-relation constraints.
     *
     * @param  T|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation<T, *, *>  $query
     */
    public function query(Model|EloquentBuilder $query, mixed $value, string $field): EloquentBuilder
    {
        $field = $this->getField($field);

        if (isset($this->key)) {
            $column = $this->qualifyKey($query, $this->key);

            // `newQuery()` keeps global scopes. Relations and builders already carry theirs.
            $query = $query instanceof Model
                ? $query->newQuery()->where($column, $value)
                : $query->where($column, $value);
        }

        /** @var \Illuminate\Database\Eloquent\Builder<T>|\Illuminate\Database\Eloquent\Relations\Relation<T, *, *> $result */
        $result = $this->{$field}($query, $value);

        return $result;
    }

    /**
     * Get the bindings available on this binder.
     *
     * @return list<string>
     */
    public function bindings(): array
    {
        $bindings = [];

        foreach ((new ReflectionClass($this))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($this->binds($method)) {
                $bindings[] = $method->getName();
            }
        }

        return $bindings;
    }

    /**
     * Get the name of the model that is generated by the binder.
     *
     * @return class-string<Model>
     */
    public function modelName(): string
    {
        if (isset($this->model)) {
            return $this->model;
        }

        if ($model = static::getBindsAttribute()) {
            return $model;
        }

        $resolver = static::$modelNameResolvers[static::class] ?? static::$modelNameResolvers[self::class] ?? function (self $binder) {
            $namespacedBinderBasename = Str::replaceLast(
                'Binder', '', Str::replaceFirst(static::$namespace, '', $binder::class)
            );

            $binderBasename = Str::replaceLast('Binder', '', class_basename($binder));

            $appNamespace = static::appNamespace();

            return class_exists($appNamespace.'Models\\'.$namespacedBinderBasename)
                ? $appNamespace.'Models\\'.$namespacedBinderBasename
                : $appNamespace.$binderBasename;
        };

        /** @var class-string<Model> */
        return $resolver($this);
    }

    /**
     * Retrieve the binder from the cache.
     *
     * @param  class-string<T>  $model
     */
    protected static function cached(string $model, string $field): ?static
    {
        // Qualified child-binding columns (`posts.slug`) are stored under the method name.
        $field = Str::afterLast($field, '.');

        if (! isset(static::$binders)) {
            // One map for the process: a `require` of the opcached file, or a single discovery pass.
            static::$binders = RetrieveBinders::get();
        }

        if (isset(static::$binders[$model][$field])) {
            $class = static::$binders[$model][$field];

            return App::make($class);
        }

        return null;
    }

    /**
     * Get the application namespace for the application.
     */
    protected static function appNamespace(): string
    {
        try {
            return Container::getInstance()
                ->make(Application::class)
                ->getNamespace();
        } catch (Throwable) {
            return 'App\\';
        }
    }

    /**
     * Qualify a binder key so child relations with joins do not match an ambiguous column.
     *
     * @param  T|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation<T, *, *>  $query
     */
    protected function qualifyKey(Model|EloquentBuilder $query, string $key): string
    {
        if (str_contains($key, '.')) {
            return $key;
        }

        $model = match (true) {
            $query instanceof Model => $query,
            $query instanceof Relation => $query->getRelated(),
            $query instanceof Builder => $query->getModel(),
            default => null,
        };

        return $model instanceof Model ? $model->qualifyColumn($key) : $key;
    }

    /**
     * Determine if the class method is for binding.
     */
    protected function binds(ReflectionMethod $method): bool
    {
        if ($method->isStatic() || str_starts_with($method->getName(), '__')) {
            return false;
        }

        $declaring = $method->getDeclaringClass();

        if ($declaring->getName() === $this::class) {
            return true;
        }

        // Methods brought in from a trait report the trait as their declaring class.
        return $declaring->isTrait()
            && in_array($declaring->getName(), trait_uses_recursive($this::class), true);
    }
}
