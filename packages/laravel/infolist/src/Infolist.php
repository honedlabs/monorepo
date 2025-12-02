<?php

declare(strict_types=1);

namespace Honed\Infolist;

use Closure;
use Honed\Core\Concerns\HasRecord;
use Honed\Core\Primitive;
use Honed\Infolist\Concerns\HasEntryables;
use Honed\Infolist\Contracts\Entryable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

/**
 * @extends \Honed\Core\Primitive<int, mixed>
 */
class Infolist extends Primitive
{
    use HasEntryables;
    use HasRecord;

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
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'infolist';

    /**
     * Create a new infolist instance.
     *
     * @param  array<string, mixed>|Model|null  $resource
     * @return static
     */
    public static function make(array|Model|null $resource = null)
    {
        return app(static::class)
            ->when($resource, fn (self $infolist, array|Model $resource) => $infolist->record($resource));
    }

    /**
     * Get a new infolist instance for the given model name.
     */
    public static function infolistForModel(Model $model): self
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
     * Get the application namespace for the application
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
     * Get the representation of the instance.
     *
     * @return array<int, mixed>
     *
     * @throws RuntimeException
     */
    protected function representation(): array
    {
        $this->define();

        $record = $this->getRecord();

        if (! $record) {
            throw new RuntimeException(
                'The infolist ['.get_class($this).'] has no record set.'
            );
        }

        return array_map(
            static fn (Entryable $primitive) => $primitive->record($record)->entry(),
            $this->getEntries()
        );
    }
}
