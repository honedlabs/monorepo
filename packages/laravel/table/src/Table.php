<?php

declare(strict_types=1);

namespace Honed\Table;

use Honed\Refine\Refine;
use Honed\Action\Handler;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Honed\Table\Columns\Column;
use Honed\Refine\Searches\Search;
use Honed\Core\Concerns\Encodable;
use Illuminate\Support\Facades\App;
use Honed\Table\Concerns\HasColumns;
use Honed\Action\Concerns\HasActions;
use Honed\Table\Concerns\HasPagination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Honed\Table\Concerns\HasTableBindings;
use Honed\Action\Concerns\HasParameterNames;
use Honed\Action\InlineAction;
use Illuminate\Contracts\Routing\UrlRoutable;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 * 
 * @extends Refine<TModel, TBuilder>
 */
class Table extends Refine implements UrlRoutable
{
    use HasColumns;
    /**
     * @use HasPagination<TModel, TBuilder>
     */
    use HasPagination;
    use Concerns\HasResource;
    use Concerns\HasToggle;
    use HasParameterNames;
    use Encodable;
    use HasActions;
    use HasParameterNames;
    use HasTableBindings;

    /**
     * The unique identifier column for the table.
     *
     * @var string|null
     */
    protected $key;

    /**
     * The endpoint to be used to handle table actions.
     *
     * @var string|null
     */
    protected $endpoint;

    /**
     * The table records.
     *
     * @var array<int,array<string,mixed>>
     */
    protected $records = [];

    /**
     * The pagination data of the table.
     *
     * @var array<string,mixed>
     */
    protected $paginationData = [];

    /**
     * {@inheritdoc}
     */
    public function __call($method, $parameters)
    {
        switch ($method) {
            case 'columns':
                /** @var array<int,\Honed\Table\Columns\Column> $columns */
                $columns = $parameters[0];

                return $this->addColumns($columns);

            case 'actions':
                /** @var array<int,\Honed\Action\Action> $actions */
                $actions = $parameters[0];

                return $this->addActions($actions);

            case 'pagination':
                /** @var int|array<int,int> $pagination */
                $pagination = $parameters[0];
                $this->pagination = $pagination;

                return $this;

            case 'paginator':
                /** @var string $paginator */
                $paginator = $parameters[0];
                $this->paginator = $paginator;

                return $this;

            case 'endpoint':
                /** @var string $endpoint */
                $endpoint = $parameters[0];
                $this->endpoint = $endpoint;

                return $this;

            default: 
                parent::__call($method, $parameters);
        };
    }

    /**
     * Create a new table instance.
     *
     * @param  \Closure|null  $before
     * @return static
     */
    public static function make($before = null)
    {
        return resolve(static::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function forwardBuilderCall($method, $parameters)
    {
        // Remove refine behaviour and prevent calling of the underlying builder.
        return $this;
    }

    /**
     * Get the unique identifier key for table records.
     *
     * @return string
     * @throws \RuntimeException
     */
    public function getRecordKey()
    {
        return $this->key // $this->getKey()
            ?? $this->getKeyColumn()?->getName()
            ?? static::throwMissingKeyException();
    }

    /**
     * Set the key property for the table.
     *
     * @param  string  $key
     * @return $this
     */
    public function key($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the endpoint to be used for table actions.
     *
     * @return string
     */
    public function getEndpoint()
    {
        if (isset($this->endpoint)) {
            return $this->endpoint;
        }

        if (\method_exists($this, 'endpoint')) {
            return $this->endpoint();
        }

        return $this->fallbackEndpoint();
    }

    /**
     * Get the records from the table.
     * 
     * @return array<int,array<string,mixed>>
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * Get the pagination data from the table.
     * 
     * @return array<string,mixed>
     */
    public function getPaginationData()
    {
        return $this->paginationData;
    }

    /**
     * Handle the incoming action request for this table.
     *
     * @param  \Honed\Action\Http\Requests\ActionRequest  $request
     * @return \Illuminate\Contracts\Support\Responsable|\Symfony\Component\HttpFoundation\RedirectResponse|void
     */
    public function handle($request)
    {
        return Handler::make(
            $this->getFor(),
            $this->getActions(),
            $this->getRecordKey()
        )->handle($request);
    }

    /**
     * Build the table. Alias for refine.
     *
     * @return $this
     */
    public function build()
    {
        return $this->refine();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $this->build();

        return \array_merge(parent::toArray(), [
            'id' => $this->getRouteKey(),
            'records' => $this->getRecords(),
            'paginator' => $this->getPaginationData(),
            'columns' => $this->columnsToArray(),
            'recordsPerPage' => $this->recordsPerPageToArray(),
            'toggleable' => $this->isToggleable(),
            'actions' => $this->actionsToArray(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configToArray()
    {
        return \array_merge(parent::configToArray(), [
            'endpoint' => $this->getEndpoint(),
            'record' => $this->getRecordKey(),
            'records' => $this->getRecordsKey(),
            'columns' => $this->getColumnsKey(),
            'pages' => $this->getPagesKey(),
        ]);
    }

    /**
     * Get the fallback endpoint to be used for table actions.
     *
     * @return string
     */
    protected function fallbackEndpoint()
    {
        return type(config('table.endpoint', '/actions'))->asString();
    }

    /**
     * {@inheritdoc}
     */
    protected function fallbackSearchesKey()
    {
        return type(config('table.config.searches', 'search'))->asString();
    }

    /**
     * {@inheritdoc}
     */
    protected function fallbackMatchesKey()
    {
        return type(config('table.config.matches', 'match'))->asString();
    }

    /**
     * {@inheritdoc}
     */
    protected function fallbackCanMatch()
    {
        return (bool) config('table.matches', false);
    }


    /**
     * Merge the column sorts with the defined sorts.
     *
     * @param  array<int,\Honed\Table\Columns\Column>  $columns
     * @return void
     */
    protected function mergeSorts($columns)
    {
        /** @var array<int,\Honed\Refine\Sorts\Sort> */
        $sorts = \array_map(
            static fn (Column $column) => $column->getSort(),
            $this->getColumnSorts($columns)
        );

        $this->addSorts($sorts);
    }

    /**
     * Merge the column searches with the defined searches.
     *
     * @param  array<int,\Honed\Table\Columns\Column>  $columns
     * @return void
     */
    protected function mergeSearches($columns)
    {
        /** @var array<int,\Honed\Refine\Searches\Search> */
        $searches = \array_map(
            static fn (Column $column) => Search::make(
                type($column->getName())->asString(),
                $column->getLabel()
            ), $this->getColumnSearches($columns)
        );

        $this->addSearches($searches);
    }

    /**
     * Get the number of records to show per page.
     * 
     * @return int
     */
    protected function getCount()
    {
        $pagination = $this->getPagination();

        if (! \is_array($pagination)) {
            return $pagination;
        }

        $param = $this->formatScope($this->getRecordsKey());
        $count = $this->getRequest()->safeInteger($param, 0);

        $this->validatePagination($count, $pagination);
        $this->createRecordsPerPage($pagination, $count);

        return $count;
    }

    /**
     * Retrieve the records from the underlying builder resource.
     *
     * @param TBuilder $builder
     * @param  array<int,\Honed\Table\Columns\Column>  $columns
     * @return void
     */
    protected function retrieveRecords($builder, $columns)
    {
        $count = $this->getCount();
        
        [$records, $this->paginationData] = $this->paginate($builder, $count);

        $actions = $this->getInlineActions();

        $this->records = $records->map(
            static fn ($record) => static::createRecord($record, $columns, $actions)
        )->all();
    }

    /**
     * Create a record for the table.
     * 
     * @param  TModel $model
     * @param  array<int,\Honed\Table\Columns\Column>  $columns
     * @param  array<int,\Honed\Action\InlineAction>  $actions
     * @return array<string,mixed>
     */
    protected static function createRecord($model, $columns, $actions)
    {
        [$named, $typed] = static::getNamedAndTypedParameters($model);

        $actions = collect($actions)
            ->filter(fn (InlineAction $action) => $action->isAllowed($named, $typed))
            ->map(fn (InlineAction $action) => $action->resolve($named, $typed))
            ->values()
            ->toArray(); // Get as array; not as array of classes

        $record = collect($columns)
            ->mapWithKeys(
                static fn (Column $column) => $column->forRecord($model)
            )->toArray();

        return \array_merge($record, ['actions' => $actions]);
    }

    /**
     * {@inheritdoc}
     */
    protected function pipeline($builder, $request)
    {
        $columns = $this->toggleColumns(
            $request,
            $this->getColumns()
        );

        $this->mergeSorts($columns);
        $this->mergeSearches($columns);

        // Use the parent pipeline to perform refinement.
        parent::pipeline($builder, $request);

        $this->retrieveRecords($builder, $columns);
    }

    /**
     * {@inheritdoc}
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        $for = $this->getFor();
        [$_, $singular, $plural] = $this->getParameterNames($for);

        return match ($parameterName) {
            'request' => [$this->getRequest()],
            'builder' => [$for],
            'resource' => [$for],
            'query' => [$for],
            $singular => [$for],
            $plural => [$for],
            default => [],
        };
    }

    /**
     * {@inheritdoc}
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        $for = $this->getFor();
        [$model] = $this->getParameterNames($for);

        return match ($parameterType) {
            Request::class => [$this->getRequest()],
            Builder::class => [$for],
            Model::class => [$for],
            $model::class => [$for],
            /** If typing reaches this point, use dependency injection. */
            default => [App::make($parameterType)],
        };
    }

    /**
     * Throw an exception if the table does not have a key column or key property 
     * defined.
     *
     * @return never
     * @throws \RuntimeException
     */
    protected static function throwMissingKeyException()
    {
        throw new \RuntimeException(
            'The table must have a key column or a key property defined.'
        );
    }
}
