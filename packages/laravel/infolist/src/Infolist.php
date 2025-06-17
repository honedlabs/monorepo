<?php

declare(strict_types=1);

namespace Honed\Infolist;

use Closure;
use Honed\Core\Exceptions\ResourceNotSetException;
use Honed\Core\Primitive;
use Honed\Infolist\Entries\BaseEntry;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Throwable;

/**
 * @extends \Honed\Core\Primitive<int, mixed>
 */
class Infolist extends Primitive
{
    use Concerns\HasEntries;

    /**
     * The default namespace where refiners reside.
     *
     * @var string
     */
    protected static $namespace = 'App\\Infolists\\';

    /**
     * How to resolve the infolist for the given model name.
     *
     * @var (Closure(class-string<Model>):class-string<Infolist>)|null
     */
    protected static $infolistResolver;

    /**
     * The resource of the infolist.
     *
     * @var array<string, mixed>|Model
     */
    protected array|Model $resource;

    /**
     * Create a new infolist instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->definition($this);
    }

    /**
     * Create a new infolist instance.
     *
     * @param  array<string, mixed>|Model|null  $resource
     */
    public static function make(array|Model|null $resource = null): static
    {
        return resolve(static::class)
            ->when($resource, fn ($infolist, $resource) => $infolist->for($resource));
    }

    /**
     * Get a new infolist instance for the given model name.
     *
     * @return Infolist
     */
    public static function infolistForModel(Model $model)
    {
        $infolist = static::resolveInfolistName($model::class);

        return $infolist::make($model);
    }

    /**
     * Get the infolist name for the given model name.
     *
     * @param  class-string<Model>  $className
     * @return class-string<Infolist>
     */
    public static function resolveInfolistName(string $className): string
    {
        $resolver = static::$infolistResolver ?? function (string $className): string {
            $appNamespace = static::appNamespace();

            $className = Str::startsWith($className, $appNamespace.'Models\\')
                ? Str::after($className, $appNamespace.'Models\\')
                : Str::after($className, $appNamespace);

            /** @var class-string<Infolist> */
            return static::$namespace.$className.'Infolist';
        };

        return $resolver($className);
    }

    /**
     * Specify the default namespace that contains the application's infolists.
     */
    public static function useNamespace(string $namespace): void
    {
        static::$namespace = $namespace;
    }

    /**
     * Specify the callback that should be invoked to guess the name of a infolist for a model.
     *
     * @param  Closure(class-string<Model>):class-string<Infolist>  $callback
     */
    public static function guessInfolistsUsing(Closure $callback): void
    {
        static::$infolistResolver = $callback;
    }

    /**
     * Flush the global configuration state.
     */
    public static function flushState(): void
    {
        static::$namespace = 'App\\Infolists\\';
        static::$infolistResolver = null;
    }

    /**
     * Set the resource of the infolist.
     *
     * @param  array<string, mixed>|Model  $resource
     * @return $this
     */
    public function for(array|Model $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get the resource to be used to generate the list.
     *
     * @return array<string, mixed>|Model
     */
    public function getResource(): array|Model
    {
        if (! $this->resource) {
            ResourceNotSetException::throw(static::class);
        }

        return $this->resource;
    }

    /**
     * Get the instance as an array.
     *
     * @return array<int, array<string, mixed>>
     */
    public function toArray()
    {
        $resource = $this->getResource();

        return array_map(
            static fn (BaseEntry $entry) => $entry
                ->record($resource)
                ->toArray(),
            $this->getEntries()
        );
    }

    /**
     * Get the application namespace for the application.
     *
     * @return string
     */
    protected static function appNamespace()
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
     * Define the infolist instance.
     *
     * @param  $this  $list
     * @return $this
     */
    protected function definition(self $list): self
    {
        return $list;
    }
}
