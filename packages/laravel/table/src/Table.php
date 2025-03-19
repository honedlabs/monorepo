<?php

declare(strict_types=1);

namespace Honed\Table;

use Honed\Refine\Refine;
use Honed\Refine\Search;
use Honed\Action\Handler;
use Honed\Core\Interpreter;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Honed\Table\Columns\Column;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\Encodable;
use Illuminate\Support\Facades\App;
use Honed\Table\Concerns\HasColumns;
use Honed\Action\Concerns\HasActions;
use Honed\Table\Concerns\IsSelectable;
use Honed\Table\Concerns\IsToggleable;
use Honed\Table\Concerns\HasPagination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Honed\Table\Concerns\HasTableBindings;
use Honed\Action\Concerns\HasParameterNames;
use Honed\Action\InlineAction;
use Honed\Refine\Pipelines\AfterRefining;
use Honed\Refine\Pipelines\BeforeRefining;
use Honed\Refine\Pipelines\RefineFilters;
use Honed\Refine\Pipelines\RefineSearches;
use Honed\Refine\Pipelines\RefineSorts;
use Honed\Table\Pipelines\ToggleColumns;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Pipeline\Pipeline;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends Refine<TModel, TBuilder>
 */
class Table extends Refine implements UrlRoutable
{
    use Encodable;
    use HasActions;
    
    /** @use HasColumns<TModel, TBuilder> */
    use HasColumns;
    use HasMeta;
    use HasParameterNames;

    /** @use HasPagination<TModel, TBuilder> */
    use HasPagination;

    use HasTableBindings;

    /** @use IsToggleable<TModel, TBuilder> */
    use IsToggleable;

    /** @use IsSelectable<TModel, TBuilder> */
    use IsSelectable;

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
     * Whether the model should be serialized per record.
     *
     * @var bool|null
     */
    protected $withAttributes;

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
     * @param  \Closure|null  $before
     * @return static
     */
    public static function make($before = null)
    {
        return resolve(static::class)->before($before);
    }

    /**
     * Get the unique identifier key for table records.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getRecordKey()
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

        throw new \RuntimeException(
            'The table must have a key column or a key property defined.'
        );
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

        return static::fallbackEndpoint();
    }

    /**
     * Get the fallback endpoint to be used for table actions from the config.
     *
     * @return string
     */
    public static function fallbackEndpoint()
    {
        return type(config('table.endpoint', '/actions'))->asString();
    }

    /**
     * {@inheritdoc}
     */
    public static function fallbackDelimiter()
    {
        return type(config('table.delimiter', ','))->asString();
    }

    /**
     * {@inheritdoc}
     */
    public static function fallbackSearchesKey()
    {
        return type(config('table.searches_key', 'search'))->asString();
    }

    /**
     * {@inheritdoc}
     */
    public static function fallbackMatchesKey()
    {
        return type(config('table.matches_key', 'match'))->asString();
    }

    /**
     * {@inheritdoc}
     */
    public static function fallbackMatching()
    {
        return (bool) config('table.match', false);
    }

    /**
     * Set whether the model should be serialized per record.
     *
     * @param  bool|null  $withAttributes
     * @return $this
     */
    public function withAttributes($withAttributes = true)
    {
        $this->withAttributes = $withAttributes;

        return $this;
    }

    /**
     * Get whether the model should be serialized per record.
     *
     * @return bool|null
     */
    public function isWithAttributes()
    {
        return (bool) ($this->withAttributes ?? static::fallbackWithAttributes());
    }

    /**
     * Get whether the model should be serialized per record from the config.
     *
     * @return bool
     */
    public static function fallbackWithAttributes()
    {
        return (bool) config('table.attributes', false);
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
     * Build the table. Alias for `refine`.
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

        $id = $this->isWithoutActions() ? null : $this->getRouteKey();

        return \array_merge(parent::toArray(), [
            'id' => $id,
            'records' => $this->getRecords(),
            'paginator' => $this->getPaginationData(),
            'columns' => $this->columnsToArray(),
            'recordsPerPage' => $this->recordsPerPageToArray(),
            'toggleable' => $this->isToggleable(),
            'actions' => $this->actionsToArray(),
            'meta' => $this->getMeta(),
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
     * Toggle the columns that are displayed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array<int,\Honed\Table\Columns\Column<TModel, TBuilder>>  $columns
     * @return array<int,\Honed\Table\Columns\Column<TModel, TBuilder>>
     */
    public function toggle($request, $columns)
    {
        if (! $this->isToggleable() || $this->isWithoutToggling()) {
            return \array_values(
                \array_filter(
                    $columns,
                    static fn (Column $column) => $column->display()
                )
            );
        }

        $key = $this->getColumnsKey();

        /** @var array<int,string>|null */
        $params = Interpreter::interpretArray(
            $request, 
            $this->formatScope($key), 
            $this->getDelimiter(), 
            'string'
        );

        if ($this->isRememberable()) {
            $params = $this->configureCookie($request, $params);
        }

        return \array_values(
            \array_filter(
                $columns,
                static fn (Column $column) => $column->display($params)
            )
        );
    }

    /**
     * Retrieve the records from the underlying builder resource.
     *
     * @param  TBuilder  $builder
     * @param  \Illuminate\Http\Request  $request
     * @param  array<int,\Honed\Table\Columns\Column<TModel, TBuilder>>  $columns
     * @return void
     */
    public function retrieveRecords($builder, $request, $columns)
    {
        [$records, $this->paginationData] = $this->paginate($builder, $request);

        $actions = $this->getInlineActions();

        $this->records = $records->map(
            fn ($record) => $this->createRecord($record, $columns, $actions)
        )->all();
    }

    /**
     * Create a record for the table.
     *
     * @param  TModel  $model
     * @param  array<int,\Honed\Table\Columns\Column<TModel, TBuilder>>  $columns
     * @param  array<int,\Honed\Action\InlineAction>  $actions
     * @return array<string,mixed>
     */
    public function createRecord($model, $columns, $actions)
    {
        [$named, $typed] = static::getModelParameters($model);

        $actions = \array_map(
            static fn (InlineAction $action) => $action->resolveToArray($named, $typed),
            $actions,
        );

        $record = $this->isWithAttributes() ? $model->toArray() : [];

        /** @var array<string,mixed> */
        $row = Arr::mapWithKeys(
            $columns,
            static fn (Column $column) => 
                $column->createRecord($model, $named, $typed),
        );

        /** @var array<string,mixed> */
        return \array_merge($record, $row, ['actions' => $actions]);
    }

    /**
     * {@inheritdoc}
     */
    protected function pipeline() {
        App::make(Pipeline::class)
            ->send($this)
            ->through([
                BeforeRefining::class,
                ToggleColumns::class,
                RefineSearches::class,
                RefineFilters::class,
                RefineSorts::class,
                SelectColumns::class,
                QueryColumns::class,
                AfterRefining::class,
                RetrieveRecords::class,
            ])->thenReturn();

        $columns = $this->toggle($request, $this->getColumns());

        /** @var array<int,\Honed\Refine\Sort<TModel, TBuilder>> */
        $sorts = \array_map(
            static fn (Column $column) => $column->getSort(),
            \array_values(
                \array_filter(
                    $columns,
                    static fn (Column $column) => $column->isSortable()
                )
            )
        );

        /** @var array<int,\Honed\Refine\Search<TModel, TBuilder>> */
        $searches = \array_map(
            static fn (Column $column) => 
                Search::make($column->getName(), $column->getLabel())
                    ->alias($column->getParameter()),
            \array_values(
                \array_filter(
                    $columns,
                    static fn (Column $column) => $column->isSearchable()
                )
            )
        );

        parent::pipeline($builder, $request, $sorts, [], $searches);

        $this->select($builder, $columns);
        $this->applyColumns($builder, $columns);
        $this->retrieveRecords($builder, $request, $columns);
    }

    /**
     * {@inheritdoc}
     */
    protected function forwardBuilderCall($method, $parameters)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $parameters)
    {
        switch ($method) {
            case 'columns':
                /** @var array<int,\Honed\Table\Columns\Column<TModel, TBuilder>> $columns */
                $columns = $parameters[0];

                return $this->addColumns($columns);

            case 'actions':
                /** @var array<int,\Honed\Action\Action> $actions */
                $actions = $parameters[0];

                return $this->addActions($actions);

            case 'defaultPagination':
                /** @var int $defaultPagination */
                $defaultPagination = $parameters[0];
                $this->defaultPagination = $defaultPagination;

                return $this;

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
                return parent::__call($method, $parameters);
        }
    }
}
