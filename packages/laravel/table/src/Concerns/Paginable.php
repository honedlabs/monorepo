<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Closure;
use Honed\Table\Enums\Paginate;
use Honed\Table\PageOption;
use Illuminate\Database\Eloquent\Builder;

use function array_map;

trait Paginable
{
    public const CURSOR = 'cursor';

    public const SIMPLE = 'simple';

    public const LENGTH_AWARE = 'length-aware';

    public const COLLECTION = 'collection';

    public const PAGE_KEY = 'page';

    public const RECORD_KEY = 'rows';

    public const PER_PAGE = 10;

    public const WINDOW = 2;

    /**
     * The paginator to use.
     *
     * @var string|(\Closure(mixed,int,string,int):array{0: mixed, 1: \Honed\Table\Pagination\PaginationData})
     */
    protected $paginator = 'length-aware';

    /**
     * The pagination options.
     *
     * @var int|array<int,int>
     */
    protected $perPage = self::PER_PAGE;

    /**
     * The default pagination amount if pagination is an array.
     *
     * @var int
     */
    protected $defaultPerPage = self::PER_PAGE;

    /**
     * The query parameter for the page number.
     *
     * @var string
     */
    protected $pageKey = self::PAGE_KEY;

    /**
     * The query parameter for the number of records to show per page.
     *
     * @var string
     */
    protected $recordKey = self::RECORD_KEY;

    /**
     * The number of page links to show either side of the current page.
     *
     * @var int
     */
    protected $window = self::WINDOW;

    /**
     * The records per page options if dynamic.
     *
     * @var array<int,PageOption>
     */
    protected $pageOptions = [];

    /**
     * Register the callback to use for custom pagination.
     *
     * @param  callable(Builder,int,string,int):Builder  $callback
     * @return $this
     */
    public function paginateUsing(callable $callback): static
    {
        $this->paginator = $callback;

        return $this;
    }

    /**
     * Set the paginator type.
     *
     * @param  string|(\Closure(mixed,int,string,int):array{0: mixed, 1: \Honed\Table\Pagination\PaginationData})  $value
     * @return $this
     */
    public function paginator(string|Paginate|Closure $value = 'length-aware')
    {
        $this->paginator = $value instanceof Paginate ? $value->value : $value;

        return $this;
    }

    /**
     * Set the paginator type to be 'length-aware'.
     *
     * @return $this
     */
    public function lengthAwarePaginator()
    {
        return $this->paginator(Paginate::LengthAware);
    }

    /**
     * Set the paginator type to be 'simple'.
     *
     * @return $this
     */
    public function simplePaginator()
    {
        return $this->paginator(Paginate::Simple);
    }

    /**
     * Set the paginator type to be 'cursor'.
     *
     * @return $this
     */
    public function cursorPaginator()
    {
        return $this->paginator(Paginate::Cursor);
    }

    /**
     * Get the paginator type.
     *
     * @return string|(\Closure(mixed,int,string,int):array{0: mixed, 1: \Honed\Table\Pagination\PaginationData})
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * Set the pagination options.
     *
     * @param  int|array<int,int>  $value
     * @return $this
     */
    public function perPage(int|array $value = 10): static
    {
        $this->perPage = $value;

        return $this;
    }

    /**
     * Get the pagination options.
     *
     * @return int|array<int,int>
     */
    public function getPerPage(): int|array
    {
        return $this->perPage;
    }

    /**
     * Set the default pagination amount.
     *
     * @return $this
     */
    public function defaultPerPage(int $value = 10): static
    {
        $this->defaultPerPage = $value;

        return $this;
    }

    /**
     * Get the default pagination amount.
     */
    public function getDefaultPerPage(): int
    {
        return $this->defaultPerPage;
    }

    /**
     * Set the query parameter for the page number.
     *
     * @return $this
     */
    public function pageKey(string $pageKey = 'page'): static
    {
        $this->pageKey = $pageKey;

        return $this;
    }

    /**
     * Get the query parameter for the page number.
     *
     * @return string
     */
    public function getPageKey(): string
    {
        return $this->scoped($this->pageKey);
    }

    /**
     * Set the query parameter for the number of records to show per page.
     *
     * @return $this
     */
    public function recordKey(string $recordKey = 'rows'): static
    {
        $this->recordKey = $recordKey;

        return $this;
    }

    /**
     * Get the query parameter for the number of records to show per page.
     *
     * @return string
     */
    public function getRecordKey(): string
    {
        return $this->scoped($this->recordKey);
    }

    /**
     * Set the number of page links to show either side of the current page.
     *
     * @param  int  $window
     * @return $this
     */
    public function window($window)
    {
        $this->window = $window;

        return $this;
    }

    /**
     * Get the number of page links to show either side of the current page.
     *
     * @return int
     */
    public function getWindow()
    {
        return $this->window;
    }

    /**
     * Create the record per page options for the table.
     *
     * @param  array<int,int>  $pagination
     * @param  int  $active
     * @return void
     */
    public function createPageOptions($pagination, $active)
    {
        $this->pageOptions = array_map(
            static fn (int $amount) => PageOption::make($amount, $active),
            $pagination
        );
    }

    /**
     * Get records per page options.
     *
     * @return array<int,PageOption>
     */
    public function getPageOptions(): array
    {
        return $this->pageOptions;
    }

    /**
     * Get the records per page options as an array.
     *
     * @return array<int,array<string,mixed>>
     */
    public function pageOptionsToArray()
    {
        return array_map(
            static fn (PageOption $record) => $record->toArray(),
            $this->getPageOptions()
        );
    }
}
