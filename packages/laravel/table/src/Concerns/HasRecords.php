<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\Page;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Honed\Action\InlineAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Honed\Action\Concerns\HasParameterNames;

trait HasRecords
{
    use HasPagination;
    use HasPaginator;
    use HasParameterNames;

    /**
     * @var array<int,\Honed\Table\Page>
     */
    protected $pages = [];

    /**
     * The records of the table retrieved from the resource.
     * 
     * @var array<int,mixed>|null
     */
    protected $records = null;

    /**
     * @var array<string,mixed>
     */
    protected $meta = [];

    /**
     * Get the records of the table.
     *
     * @return array<int,mixed>|null
     */
    public function getRecords(): ?array
    {
        return $this->records;
    }

    /**
     * Get the meta data of the table.
     * 
     * @return array<string,mixed>
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * Determine if the table has records.
     */
    public function hasRecords(): bool
    {
        return ! \is_null($this->records);
    }

    /**
     * Get the page options of the table.
     * 
     * @return array<int,\Honed\Table\Page>
     */
    public function getPages(): array
    {
        return $this->pages;
    }
    
    /**
     * Format the records using the provided columns.
     * 
     * @param array<int,\Honed\Table\Columns\Column> $activeColumns
     */
    public function formatAndPaginate(array $activeColumns): void
    {
        if ($this->hasRecords()) {
            return;
        }

        /**
         * @var \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>
         */
        $builder = $this->getBuilder();

        $paginator = $this->getPaginator();

        /**
         * @var array<int,\Illuminate\Database\Eloquent\Model> $records
         */
        [$records, $this->meta] = match (true) {
            $this->isLengthAware($paginator) => $this->lengthAwarePaginateRecords($builder),

            $this->isSimple($paginator) => $this->simplePaginateRecords($builder),

            $this->isCursor($paginator) => $this->cursorPaginateRecords($builder),

            $this->isCollection($paginator) => $this->collectRecords($builder),
            
            default => static::throwInvalidPaginatorException($paginator),
        };

        $formattedRecords = [];

        foreach ($records as $record) {
            $formattedRecords[] = $this->formatRecord($record, $activeColumns);
        }
        
        $this->records = $formattedRecords;
    }

    /**
     * Get the number of records to show per page.
     */
    protected function getRecordsPerPage(): int
    {
        $pagination = $this->getPagination();
        
        if (! \is_array($pagination)) {
            return $pagination;
        }

        $perPage = $this->getRecordsFromRequest();

        $perPage = \in_array($perPage, $pagination)
            ? $perPage
            : $this->getDefaultPagination();

        $this->pages = Arr::map($pagination, 
            static fn (int $amount) => Page::make($amount, $perPage)
        );

        return $perPage;
    }

    /**
     * Get the number of records to show per page from the request.
     */
    protected function getRecordsFromRequest(): int
    {
        /**
         * @var \Illuminate\Http\Request
         */
        $request = $this->getRequest();

        return $request->integer(
            $this->getRecordsKey(),
            $this->getDefaultPagination(),
        );
    }

    /**
     * Format a record using the provided columns.
     * 
     * @param \Illuminate\Database\Eloquent\Model $record
     * @param array<int,\Honed\Table\Columns\Column> $columns
     * 
     * @return array<string,mixed>
     */
    protected function formatRecord(Model $record, array $columns): array
    {
        $reducing = false;

        [$named, $typed] = static::getNamedAndTypedParameters($record);

        $actions = Arr::map(
            Arr::where(
                $this->inlineActions(),
                fn (InlineAction $action) => $action->isAllowed($named, $typed)
            ),
            fn (InlineAction $action) => $action->resolve($named, $typed)->toArray(),
        );

        // $formatted = ($reducing) ? [] : $record->toArray(); // @phpstan-ignore-line
        $formatted = [];

        foreach ($columns as $column) {
            $name = $column->getName();

            Arr::set($formatted, 
                Str::replace('.', '_', $name),
                Arr::get($record, $name)
            );
        }

        Arr::set($formatted, 'actions', $actions);

        return $formatted;
    }

    /**
     * Length-aware paginate the records from the builder.
     * 
     * @template T of \Illuminate\Database\Eloquent\Model
     * 
     * @param \Illuminate\Database\Eloquent\Builder<T> $builder
     * 
     * @return array{0:array<int,T>,1:array<string,mixed>}
     */
    protected function lengthAwarePaginateRecords(Builder $builder): array
    {
        /**
         * @var \Illuminate\Pagination\LengthAwarePaginator<T> $paginated
         */
        $paginated = $builder->paginate(
            perPage: $this->getRecordsPerPage(),
            pageName: $this->getPageKey(),
        );

        $paginated->withQueryString();

        return [
            $paginated->getCollection(),
            $this->lengthAwarePaginatorMetadata($paginated),
        ];
    }

    /**
     * Simple paginate the records from the builder.
     * 
     * @template T of \Illuminate\Database\Eloquent\Model
     * 
     * @param \Illuminate\Database\Eloquent\Builder<T> $builder
     * 
     * @return array{0:\Illuminate\Support\Collection<int,T>,1:array<string,mixed>}
     */
    protected function simplePaginateRecords(Builder $builder): array
    {
        /**
         * @var \Illuminate\Pagination\Paginator<T> $paginated
         */
        $paginated = $builder->simplePaginate(
            perPage: $this->getRecordsPerPage(),
            pageName: $this->getPageKey(),
        );

        $paginated->withQueryString();

        return [
            $paginated->getCollection(),
            $this->simplePaginatorMetadata($paginated),
        ];
    }

    /**
     * Cursor paginate the records from the builder.
     * 
     * @template T of \Illuminate\Database\Eloquent\Model
     * 
     * @param \Illuminate\Database\Eloquent\Builder<T> $builder
     * 
     * @return array{0:\Illuminate\Support\Collection<int,T>,1:array<string,mixed>}
     */
    protected function cursorPaginateRecords(Builder $builder): array
    {
        /**
         * @var \Illuminate\Pagination\CursorPaginator<T> $paginated
         */
        $paginated = $builder->cursorPaginate(
            perPage: $this->getRecordsPerPage(),
            cursorName: $this->getPageKey(),
        );

        $paginated->withQueryString();

        return [
            $paginated->getCollection(),
            $this->cursorPaginatorMetadata($paginated),
        ];
    }

    /**
     * Collect the records from the builder.
     * 
     * @template T of \Illuminate\Database\Eloquent\Model
     * 
     * @param \Illuminate\Database\Eloquent\Builder<T> $builder
     * 
     * @return array{0:\Illuminate\Support\Collection<int,T>,1:array<string,mixed>}
     */
    protected function collectRecords(Builder $builder): array
    {
        $retrieved = $builder->get();

        return [
            $retrieved,
            []
        ];
    }

    /**
     * Throw an exception for an invalid paginator type.
     */
    protected static function throwInvalidPaginatorException(string $paginator): never
    {
        throw new \InvalidArgumentException(
            \sprintf('The paginator [%s] is not valid.', $paginator
        ));
    }
    
}
