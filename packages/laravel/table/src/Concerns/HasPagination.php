<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\PageOption;
use Honed\Table\PerPageRecord;
use Illuminate\Support\Collection;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 *
 * @template-covariant TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
trait HasPagination
{
    public const CURSOR = 'cursor';
    public const SIMPLE = 'simple';
    public const LENGTH_AWARE = 'length-aware';
    public const COLLECTION = 'collection';

    /**
     * The paginator to use.
     *
     * @var string|null
     */
    protected $paginate;

    /**
     * The pagination options.
     *
     * @var int|array<int,int>
     */
    protected $perPage = 10;

    /**
     * The default pagination amount if pagination is an array.
     *
     * @var int
     */
    protected $defaultPerPage = 10;

    /**
     * The query parameter for the page number.
     *
     * @var string
     */
    protected $pageKey = 'page';

    /**
     * The query parameter for the number of records to show per page.
     *
     * @var string
     */
    protected $recordKey = 'rows';

    /**
     * The number of page links to show either side of the current page.
     *
     * @var int
     */
    protected $window = 2;

    /**
     * The records per page options if dynamic.
     *
     * @var array<int,\Honed\Table\PerPageRecord>
     */
    protected $recordsPerPage = [];

    /**
     * Set the paginator type.
     *
     * @param  bool|string  $paginator
     * @return $this
     */
    public function paginate($paginator = self::LENGTH_AWARE)
    {
        $this->paginator = match ($paginator) {
            true => $paginator = self::LENGTH_AWARE,
            false => $paginator = self::COLLECTION,
            default => $paginator,
        };

        return $this;
    }

    /**
     * Set the paginator type to be 'length-aware'.
     *
     * @return $this
     */
    public function lengthAwarePaginate()
    {
        return $this->paginate(self::LENGTH_AWARE);
    }

    /**
     * Set the paginator type to be 'simple'.
     *
     * @return $this
     */
    public function simplePaginate()
    {
        return $this->paginate(self::SIMPLE);
    }

    /**
     * Set the paginator type to be 'cursor'.
     *
     * @return $this
     */
    public function cursorPaginate()
    {
        return $this->paginate(self::CURSOR);
    }

    /**
     * Set the paginator type to be 'collection'.
     *
     * @return $this
     */
    public function collectionPaginate()
    {
        return $this->paginate(self::COLLECTION);
    }

    /**
     * Get the paginator type.
     *
     * @return string
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * Set the pagination options.
     *
     * @param  int|array<int,int>  $perPage
     * @return $this
     */
    public function perPage($perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * Get the pagination options.
     *
     * @return int|array<int,int>
     */
    public function getPerPage()
    {
        return $this->perPage;
    }


    /**
     * Set the default pagination amount.
     *
     * @param  int  $perPage
     * @return $this
     */
    public function defaultPerPage($perPage)
    {
        $this->defaultPerPage = $perPage;

        return $this;
    }

    /**
     * Get the default pagination amount.
     *
     * @return int
     */
    public function getDefaultPerPage()
    {
        return $this->defaultPerPage;
    }

    /**
     * Set the query parameter for the page number.
     *
     * @param  string  $pageKey
     * @return $this
     */
    public function pageKey($pageKey)
    {
        $this->pageKey = $pageKey;

        return $this;
    }

    /**
     * Get the query parameter for the page number.
     *
     * @return string
     */
    public function getPageKey()
    {
        return $this->pageKey;
    }

    /**
     * Set the query parameter for the number of records to show per page.
     *
     * @param  string  $recordKey
     * @return $this
     */
    public function recordKey($recordKey)
    {
        $this->recordKey = $recordKey;

        return $this;
    }

    /**
     * Get the query parameter for the number of records to show per page.
     *
     * @return string
     */
    public function getRecordKey()
    {
        return $this->recordKey;
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
    public function createRecordsPerPage($pagination, $active)
    {
        $this->recordsPerPage = \array_map(
            static fn (int $amount) => PerPageRecord::make($amount, $active),
            $pagination
        );
    }

    /**
     * Get records per page options.
     *
     * @return array<int,\Honed\Table\PerPageRecord>
     */
    public function getRecordsPerPage()
    {
        return $this->pageOptions;
    }

    /**
     * Get the records per page options as an array.
     *
     * @return array<int,array<string,mixed>>
     */
    public function recordsPerPageToArray()
    {
        return \array_map(
            static fn (PageOption $record) => $record->toArray(),
            $this->getRecordsPerPage()
        );
    }

    /**
     * Determine if the paginator is a length-aware paginator.
     *
     * @param  string  $paginator
     * @return bool
     */
    public function isLengthAware($paginator)
    {
        return \in_array($paginator, [
            'length-aware',
            \Illuminate\Contracts\Pagination\LengthAwarePaginator::class,
            \Illuminate\Pagination\LengthAwarePaginator::class,
        ]);
    }

    /**
     * Determine if the paginator is a simple paginator.
     *
     * @param  string  $paginator
     * @return bool
     */
    public function isSimple($paginator)
    {
        return \in_array($paginator, [
            'simple',
            \Illuminate\Contracts\Pagination\Paginator::class,
            \Illuminate\Pagination\Paginator::class,
        ]);
    }

    /**
     * Determine if the paginator is a cursor paginator.
     *
     * @param  string  $paginator
     * @return bool
     */
    public function isCursor($paginator)
    {
        return \in_array($paginator, [
            'cursor',
            \Illuminate\Contracts\Pagination\CursorPaginator::class,
            \Illuminate\Pagination\CursorPaginator::class,
        ]);
    }

    /**
     * Determine if the paginator is a collection.
     *
     * @param  string  $paginator
     * @return bool
     */
    public function isCollector($paginator)
    {
        return \in_array($paginator, [
            'none',
            'collection',
            \Illuminate\Support\Collection::class,
        ]);
    }

    /**
     * Get the pagination data for the length-aware paginator.
     *
     * @param  \Illuminate\Contracts\Pagination\LengthAwarePaginator<TModel>  $paginator
     * @return array<string, mixed>
     */
    public function lengthAwarePaginator($paginator)
    {
        return \array_merge($this->simplePaginator($paginator), [
            'total' => $paginator->total(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'firstLink' => $paginator->url(1),
            'lastLink' => $paginator->url($paginator->lastPage()),
            'links' => $this->createPaginatorLinks($paginator),
        ]);
    }

    /**
     * Create pagination links with a sliding window around the current page.
     *
     * @param  \Illuminate\Contracts\Pagination\LengthAwarePaginator<TModel>  $paginator
     * @return array<int, array<string, mixed>>
     */
    public function createPaginatorLinks($paginator)
    {
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $onEachSide = $this->getWindow();

        $start = max(1, min($currentPage - $onEachSide, $lastPage - ($onEachSide * 2)));
        $end = min($lastPage, max($currentPage + $onEachSide, ($onEachSide * 2 + 1)));

        return \array_map(
            static fn (int $page) => [
                'url' => $paginator->url($page),
                'label' => (string) $page,
                'active' => $currentPage === $page,
            ],
            range($start, $end)
        );
    }

    /**
     * Get the pagination data for the simple paginator.
     *
     * @param  \Illuminate\Contracts\Pagination\Paginator<TModel>  $paginator
     * @return array<string, mixed>
     */
    public function simplePaginator($paginator)
    {
        return \array_merge($this->cursorPaginator($paginator), [
            'currentPage' => $paginator->currentPage(),
        ]);
    }

    /**
     * Get the pagination data for the cursor paginator.
     *
     * @param  \Illuminate\Pagination\AbstractCursorPaginator<TModel>|\Illuminate\Contracts\Pagination\Paginator<TModel>  $paginator
     * @return array<string, mixed>
     */
    public function cursorPaginator($paginator)
    {
        return \array_merge($this->collectionPaginator($paginator), [
            'prevLink' => $paginator->previousPageUrl(),
            'nextLink' => $paginator->nextPageUrl(),
            'perPage' => $paginator->perPage(),
        ]);
    }

    /**
     * Get the base metadata for the collection paginator, and all others.
     *
     * @param  \Illuminate\Support\Collection<int,TModel>|\Illuminate\Pagination\AbstractCursorPaginator<TModel>|\Illuminate\Contracts\Pagination\Paginator<TModel>  $paginator
     * @return array<string, mixed>
     */
    public function collectionPaginator($paginator)
    {
        return [
            'empty' => $paginator->isEmpty(),
        ];
    }
}
