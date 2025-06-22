<?php

declare(strict_types=1);

namespace Honed\Table;

use Honed\Refine\Refine;
use Honed\Action\Handler;
use Honed\Core\Primitive;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Honed\Table\Pipes\Select;
use Honed\Table\Pipes\Toggle;
use Honed\Table\Columns\Column;
use Honed\Core\Concerns\HasMeta;
use Honed\Refine\Pipes\SortQuery;
use Illuminate\Pipeline\Pipeline;
use Honed\Action\Contracts\Handles;
use Honed\Refine\Pipes\FilterQuery;
use Honed\Refine\Pipes\PersistData;
use Honed\Refine\Pipes\SearchQuery;
use Honed\Table\Pipelines\Paginate;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\App;
use Honed\Core\Concerns\HasPipeline;
use Honed\Table\Concerns\HasColumns;
use Honed\Action\Concerns\HasActions;
use Honed\Action\Concerns\HasEncoder;
use Honed\Refine\Pipes\AfterRefining;
use Honed\Action\Concerns\HasEndpoint;
use Honed\Refine\Pipes\BeforeRefining;
use Honed\Table\Concerns\IsToggleable;
use Honed\Table\Pipelines\RefineSorts;
use Honed\Action\Handlers\BatchHandler;
use Honed\Refine\Concerns\CanBeRefined;
use Honed\Refine\Contracts\RefinesData;
use Honed\Table\Concerns\HasEmptyState;
use Honed\Table\Concerns\HasPagination;
use Honed\Table\Contracts\ShouldSelect;
use Honed\Table\Pipelines\CleanupTable;
use Honed\Table\Pipelines\QueryColumns;
use Honed\Table\Pipes\CreateEmptyState;
use Honed\Table\Pipelines\RefineFilters;
use Honed\Table\Pipelines\SelectColumns;
use Honed\Table\Pipelines\ToggleColumns;
use Honed\Table\Pipelines\RefineSearches;
use Illuminate\Database\Eloquent\Builder;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Table\Pipelines\TransformRecords;
use Honed\Action\Contracts\HandlesOperations;
use Illuminate\Contracts\Routing\UrlRoutable;
use Honed\Action\Concerns\CanHandleOperations;
use Honed\Table\Exceptions\KeyNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Honed\Refine\Pipes\BeforeRefining as PipesBeforeRefining;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends Primitive<string, mixed>
 */
class Table extends Primitive implements HandlesOperations, RefinesData, NullsAsUndefined
{
    use CanBeRefined;
    use CanHandleOperations;
    use HasColumns;
    use HasMeta;
    use HasEmptyState;

    /**
     * The unique identifier key for table records.
     *
     * @var string|null
     */
    protected $key;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'table';

    /**
     * The default namespace where tables reside.
     *
     * @var string
     */
    public static $namespace = 'App\\Tables\\';

    /**
     * How to resolve the table for the given model name.
     *
     * @var (\Closure(class-string<\Illuminate\Database\Eloquent\Model>):class-string<\Honed\Table\Table>)|null
     */
    protected static $tableNameResolver;

    /**
     * Create a new table instance.
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function __construct(Request $request)
    {
        parent::__construct();

        $this->request($request);

        $this->definition($this);
    }

    /**
     * Create a new table instance.
     *
     * @param  \Closure(TBuilder):void|null  $before
     * @return static
     */
    public static function make($before = null)
    {
        return resolve(static::class)
            ->before($before);
    }

    /**
     * Set the record key to use.
     *
     * @param  string|null  $key
     * @return $this
     */
    public function key($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the unique identifier key for table records.
     *
     * @return string
     *
     * @throws \Honed\Table\Exceptions\KeyNotFoundException
     */
    public function getKey()
    {
        if (isset($this->key)) {
            return $this->key;
        }

        $keyColumn = Arr::first(
            $this->getColumns(),
            static fn (Column $column): bool => $column->isKey()
        );

        if ($keyColumn) {
            return $keyColumn->getName();
        }

        KeyNotFoundException::throw(static::class);
    }

    /**
     * Get a new table instance for the given model name.
     *
     * @template TClass of \Illuminate\Database\Eloquent\Model
     *
     * @param  class-string<TClass>  $modelName
     * @param  \Closure|null  $before
     * @return \Honed\Table\Table<TClass>
     */
    public static function tableForModel($modelName, $before = null)
    {
        $table = static::resolveTableName($modelName);

        return $table::make($before);
    }

    /**
     * Get the table name for the given model name.
     *
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $className
     * @return class-string<\Honed\Table\Table>
     */
    public static function resolveTableName($className)
    {
        $resolver = static::$tableNameResolver ?? function (string $className) {
            $appNamespace = static::appNamespace();

            $className = Str::startsWith($className, $appNamespace.'Models\\')
                ? Str::after($className, $appNamespace.'Models\\')
                : Str::after($className, $appNamespace);

            /** @var class-string<\Honed\Table\Table> */
            return static::$namespace.$className.'Table';
        };

        return $resolver($className);
    }

    /**
     * Specify the default namespace that contains the application's model tables.
     *
     * @param  string  $namespace
     * @return void
     */
    public static function useNamespace($namespace)
    {
        static::$namespace = $namespace;
    }

    /**
     * Specify the callback that should be invoked to guess the name of a model table.
     *
     * @param  \Closure(class-string<\Illuminate\Database\Eloquent\Model>):class-string<\Honed\Table\Table>  $callback
     * @return void
     */
    public static function guessTableNamesUsing($callback)
    {
        static::$tableNameResolver = $callback;
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
        } catch (\Throwable) {
            return 'App\\';
        }
    }

    /**
     * Flush the table class global configuration state.
     *
     * @return void
     */
    public static function flushState()
    {
        static::$namespace = 'App\\Tables\\';
        static::$tableNameResolver = null;
    }

    /**
     * Get the parent class for the instance.
     *
     * @return class-string<Table>
     */
    public static function getParentClass()
    {
        return self::class;
    }

    /**
     * Get the route key for the instance.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'table';
    }

    /**
     * Get the handler for the instance.
     *
     * @return class-string<\Honed\Action\Handlers\Handler<self>>
     */
    public function getHandler() // @phpstan-ignore-line
    {
        /** @var class-string<Handlers\Handler<self>> */
        return config('action.handler', BatchHandler::class);
    }


    /**
     * Get the actions for the table as an array.
     *
     * @return array<string, mixed>
     */
    public function actionsToArray()
    {
        return [
            'inline' => filled($this->getInlineActions()),
            'bulk' => $this->getBulkActions(),
            'page' => $this->getPageActions(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $this->build();

        return [
            ...$this->refineToArray(),
            'records' => $this->getRecords(),
            'paginate' => $this->getPagination(),
            'columns' => $this->columnsToArray(),
            'pages' => $this->pageToArray(),
            'toggleable' => $this->isToggleable(),
            'actions' => $this->actionsToArray(),
            'meta' => $this->getMeta(),
        ];

        $table = \array_merge(parent::toArray(), [
            'records' => $this->getRecords(),
            'paginator' => $this->getPaginationData(),
            'columns' => $this->columnsToArray(),
            'perPage' => $this->recordsPerPageToArray(),
            'toggles' => $this->isToggleable(),
            'actions' => $this->actionsToArray(),
            'meta' => $this->getMeta(),
        ]);

        if (Arr::get($this->getPaginationData(), 'empty', false)) {
            $table = \array_merge($table, [
                'empty' => $this->getEmptyState()->toArray(),
            ]);
        }

        if ($this->isExecutable(static::baseClass())) {
            return \array_merge($table, [
                'id' => $this->getRouteKey(),
            ]);
        }

        return $table;
    }

    /**
     * Handle dynamic method calls into the method.
     *
     * @param  string  $method
     * @param  array<int,mixed>  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->macroCall($method, $parameters);
    }

    /**
     * Define the table.
     *
     * @param  $this  $table
     * @return $this
     */
    protected function definition(self $table): self
    {
        return $table;
    }

    /**
     * Get the pipes to be used for refining.
     *
     * @return array<int,class-string<\Honed\Core\Pipe<self>>>
     */
    protected function pipes()
    {
        return [
            Toggle::class,
            BeforeRefining::class,
            Select::class,
            SearchQuery::class,
            FilterQuery::class,
            SortQuery::class,
            AfterRefining::class,
            CreateEmptyState::class,
            PersistData::class,
        ];
        
    }

    /**
     * Provide a selection of default dependencies for evaluation by name.
     *
     * @param  string  $parameterName
     * @return array<int, mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        return match ($parameterName) {
            'columns' => [$this->getColumns()],
            'emptyState' => [$this->getEmptyState()],
            'request' => [$this->getRequest()],
            'builder', 'query', 'q' => [$this->getBuilder()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * Provide a selection of default dependencies for evaluation by type.
     *
     * @param  string  $parameterType
     * @return array<int, mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        $builder = $this->getBuilder();

        return match ($parameterType) {
            EmptyState::class => [$this->getEmptyState()],
            Request::class => [$this->getRequest()],
            $builder::class, Builder::class, BuilderContract::class => [$builder],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }
}
