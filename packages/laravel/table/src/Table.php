<?php

declare(strict_types=1);

namespace Honed\Table;

use Honed\Action\Concerns\HasActions;
use Honed\Action\Concerns\HasParameterNames;
use Honed\Action\Handler;
use Honed\Core\Concerns\Encodable;
use Honed\Refine\Refine;
use Honed\Refine\Searches\Search;
use Honed\Table\Columns\Column;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

/**
 * @extends Refine<\Illuminate\Database\Eloquent\Model>
 */
class Table extends Refine implements UrlRoutable
{
    use Concerns\HasColumns;
    use Concerns\HasPagination;
    use Concerns\HasResource;
    use Concerns\HasToggle;
    use HasParameterNames;
    use Encodable;
    use HasActions;
    use HasParameterNames;
    use Concerns\HasTableBindings;

    /**
     * A unique identifier column for the table.
     *
     * @var string|null
     */
    protected $key;

    /**
     * An optional closure to modify the builder before it is refined.
     *
     * @var \Closure|null
     */
    protected $modifier;

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
     * Create a new table instance.
     *
     * @param  \Closure|null  $modifier
     * @return static
     */
    public static function make($modifier = null)
    {
        return resolve(static::class)
            ->modifier($modifier);
    }

    /**
     * Get the unique identifier key for table records.
     *
     * @return string
     * @throws \RuntimeException
     */
    public function getRecordKey()
    {
        return $this->key
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
     * Set the resource modifier callback.
     *
     * @param  \Closure|null  $modifier
     * @return $this
     */
    public function modifier($modifier)
    {
        $this->modifier = $modifier;

        return $this;
    }

    /**
     * Get the resource modifier.
     *
     * @return \Closure|null
     */
    public function getModifier()
    {
        return $this->modifier;
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

        return $this->getFallbackEndpoint();
    }

    /**
     * Get the fallback endpoint to be used for table actions.
     *
     * @return string
     */
    public function getFallbackEndpoint()
    {
        return type(config('table.endpoint', '/actions'))->asString();
    }

    /**
     * {@inheritdoc}
     */
    protected function getFallbackSearchesKey()
    {
        return type(config('table.config.searches', 'search'))->asString();
    }

    /**
     * {@inheritdoc}
     */
    protected function getFallbackMatchesKey()
    {
        return type(config('table.config.matches', 'match'))->asString();
    }

    /**
     * {@inheritdoc}
     */
    protected function getFallbackCanMatch()
    {
        return (bool) config('table.matches', false);
    }

    /**
     * {@inheritdoc}
     */
    public function getBuilder()
    {
        $this->builder ??= $this->createBuilder(
            $this->getResource()
        );

        return parent::getBuilder();
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
            $this->getBuilder(),
            $this->getActions(),
            $this->getKey()
        )->handle($request);
    }

    /**
     * {@inheritdoc}
     */
    public function __call($name, $arguments)
    {
        $args = Arr::first($arguments);

        match ($name) {
            'columns' => $this->addColumns($args), // @phpstan-ignore-line
            'sorts' => $this->addSorts($args), // @phpstan-ignore-line
            'filters' => $this->addFilters($args), // @phpstan-ignore-line
            'searches' => $this->addSearches($args), // @phpstan-ignore-line
            'actions' => $this->addActions($args), // @phpstan-ignore-line
            'pagination' => $this->pagination = $args, // @phpstan-ignore-line
            'paginator' => $this->paginator = $args, // @phpstan-ignore-line
            'endpoint' => $this->endpoint = $args, // @phpstan-ignore-line
            default => null,
        };

        return $this;
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
            fn (Column $column) => $column->getSort(),
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
            fn (Column $column) => Search::make(
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
     * @param  array<int,\Honed\Table\Columns\Column>  $columns
     * @return void
     */
    protected function retrieveRecords($columns)
    {
        $builder = $this->getBuilder();
        $count = $this->getCount();
        
        [$records, $this->paginationData] = $this->paginate($builder, $count);

        // Get the inline actions once to prevent repeated filters
        $actions = $this->getInlineActions();

        $this->records = $records->map(
            fn ($record) => $this->createRecord($record, $columns, $actions)
        )->all();
    }

    /**
     * Create a record for the table.
     * 
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  array<int,\Honed\Table\Columns\Column>  $columns
     * @param  array<int,\Honed\Action\InlineAction>  $actions
     * @return array<string,mixed>
     */
    protected function createRecord($model, $columns, $actions)
    {
        [$named, $typed] = static::getNamedAndTypedParameters($model);

        $actions = collect($actions)
            ->filter(fn ($action) => $action->isAllowed($named, $typed))
            ->map(fn ($action) => $action->resolve($named, $typed))
            ->values()
            ->toArray();

        $record = collect($columns)
            ->mapWithKeys(fn (Column $column) => $this->formatColumn($column, $model))
            ->toArray();

        return \array_merge($record, ['actions' => $actions]);
    }

    /**
     * Build the table using the given request.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->isRefined()) {
            return $this;
        }

        // If toggling is enabled, we need to determine which
        // columns are to be used from the request, cookie or by the
        // default state of each column.
        $columns = $this->toggle($this->getColumns());

        // Before refining, merge the column sorts and searches
        // with the defined sorts and searches.
        $this->mergeSorts($columns);
        $this->mergeSearches($columns);

        // Intermediate step allowing for table reuse with
        // minor changes between them.
        $this->evaluate($this->getModifier());

        // Execute the parent refine method to scope the builder
        // according to the given request.
        $this->refine();

        // Retrieved the records, generate metadata and complete the
        // table pipeline.
        $this->retrieveRecords($columns);

        return $this;
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
     * {@inheritdoc}
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        [$_, $singular, $plural] = $this->getParameterNames($this->getBuilder());

        return match ($parameterName) {
            'builder' => [$this->getBuilder()],
            'resource' => [$this->getResource()],
            'query' => [$this->getBuilder()],
            'request' => [$this->getRequest()],
            $singular => [$this->getBuilder()],
            $plural => [$this->getBuilder()],
            default => [],
        };
    }

    /**
     * {@inheritdoc}
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        [$model] = $this->getParameterNames($this->getBuilder());

        return match ($parameterType) {
            Builder::class => [$this->getBuilder()],
            Model::class => [$this->getBuilder()],
            Request::class => [$this->getRequest()],
            $model::class => [$this->getBuilder()],
            /** If typing reaches this point, use dependency injection. */
            default => [App::make($parameterType)],
        };
    }

    /**
     * Throw an exception if the table does not have a key column or key property defined.
     *
     * @return never
     */
    protected static function throwMissingKeyException()
    {
        throw new \RuntimeException(
            'The table must have a key column or a key property defined.'
        );
    }
}
