<?php

declare(strict_types=1);

namespace Honed\Action;

use Closure;
use Honed\Action\Concerns\CanHandleOperations;
use Honed\Action\Contracts\Handler;
use Honed\Action\Contracts\HandlesOperations;
use Honed\Action\Handler as ActionHandler;
use Honed\Core\Concerns\HasRecord;
use Honed\Core\Primitive;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Str;
use Throwable;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 */
class Batch extends Primitive implements HandlesOperations
{
    use CanHandleOperations;
    use HasRecord;

    /**
     * The default namespace where batches reside.
     *
     * @var string
     */
    public static $namespace = 'App\\Batches\\';

    /**
     * How to resolve the batch for the given model name.
     *
     * @var (Closure(class-string):class-string<Batch>)|null
     */
    protected static $batchNameResolver = null;

    /**
     * Create a new batch instance.
     *
     * @param  Operation|Batch|array<int, Operation|Batch>  $operations
     * @return static
     */
    public static function make($operations = [])
    {
        return resolve(static::class)
            ->operations($operations);
    }

    /**
     * Get a new table instance for the given model name.
     *
     * @template TClass of \Illuminate\Database\Eloquent\Model
     *
     * @param  class-string<TClass>  $modelName
     * @return static
     */
    public static function batchForModel($modelName)
    {
        $table = static::resolveBatchName($modelName);

        return $table::make();
    }

    /**
     * Get the table name for the given model name.
     *
     * @param  class-string  $className
     * @return class-string<Batch>
     */
    public static function resolveBatchName($className)
    {
        $resolver = static::$batchNameResolver ?? function (string $className) {
            $appNamespace = static::appNamespace();

            $className = Str::startsWith($className, $appNamespace.'Models\\')
                ? Str::after($className, $appNamespace.'Models\\')
                : Str::after($className, $appNamespace);

            /** @var class-string<Batch> */
            return static::$namespace.$className.'Batch';
        };

        return $resolver($className);
    }

    /**
     * Specify the default namespace that contains the application's model batches.
     *
     * @param  string  $namespace
     * @return void
     */
    public static function useNamespace($namespace)
    {
        static::$namespace = $namespace;
    }

    /**
     * Specify the callback that should be invoked to guess the name of a model batch.
     *
     * @param  Closure(class-string):class-string<Batch>  $callback
     * @return void
     */
    public static function guessBatchNamesUsing($callback)
    {
        static::$batchNameResolver = $callback;
    }

    /**
     * Flush the batch's global configuration state.
     *
     * @return void
     */
    public static function flushState()
    {
        static::$encoder = null;
        static::$decoder = null;
        static::$batchNameResolver = null;
        static::$namespace = 'App\\Batches\\';
    }

    /**
     * Get the parent class for the instance.
     *
     * @return class-string<Batch>
     */
    public static function getParentClass()
    {
        return self::class;
    }

    /**
     * Set the record to be used for the batch.
     *
     * @param  array<string, mixed>|TModel  $model
     * @return $this
     */
    public function for($model)
    {
        return $this->record($model);
    }

    /**
     * Get the route key for the instance.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'action';
    }

    /**
     * Get the handler for the instance.
     *
     * @return class-string<Handlers\Handler>
     */
    public function getHandler()
    {
        /** @var class-string<Handlers\Handler> */
        return config('action.handler', ActionHandler::class);
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray()
    {
        $operations = [
            'inline' => $this->inlineOperationsToArray($this->getRecord()),
            'bulk' => $this->bulkOperationsToArray(),
            'page' => $this->pageOperationsToArray(),
        ];

        if ($this->isExecutable(self::class)) {
            return [
                ...$operations,
                'id' => $this->getRouteKey(),
                'endpoint' => $this->getEndpoint(),
            ];
        }

        return $operations;
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
     * Define the operations for the batch.
     *
     * @param  $this  $batch
     * @return $this
     */
    protected function definition(self $batch): self
    {
        return $batch;
    }
}
