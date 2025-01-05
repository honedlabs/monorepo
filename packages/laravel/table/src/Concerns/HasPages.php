<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Honed\Table\Exceptions\InvalidPaginatorException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator as PaginationCursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Support\Collection;

trait HasPages
{
    /**
     * @var int|array<int,int>
     */
    protected $perPage;

    /**
     * @var int
     */
    protected $defaultPerPage;

    /**
     * @var int|array<int,int>
     */
    protected static $defaultPerPageAmount = 10;

    /**
     * @var 'cursor'|'simple'|'length-aware'|class-string<\Illuminate\Contracts\Pagination\Paginator>|null
     */
    protected $paginator;

    /**
     * @var 'cursor'|'simple'|'length-aware'|class-string<\Illuminate\Contracts\Pagination\Paginator>
     */
    protected static $defaultPaginator = LengthAwarePaginator::class;

    /**
     * @var string
     */
    protected $page;

    /**
     * Use the default page key.
     * 
     * @var string|null
     */
    protected static $pageKey = null;

    /**
     * @var string
     */
    protected $count;

    /**
     * @var string
     */
    protected static $countKey = 'show';

    /**
     * Configure the options for the number of records to show per page.
     *
     * @param  int|array<int,int>  $perPage
     */
    public static function recordsPerPage(int|array $perPage): void
    {
        static::$defaultPerPageAmount = $perPage;
    }

    /**
     * Configure the paginator to use.
     *
     * @param 'cursor'|'simple'|'length-aware'|class-string<\Illuminate\Contracts\Pagination\Paginator> $paginator
     */
    public static function usePaginator(string $paginator): void
    {
        static::$defaultPaginator = $paginator;
    }

    /**
     * Configure the query parameter name to use for the current page number being shown.
     */
    public static function usePageKey(?string $name): void
    {
        static::$pageKey = $name;
    }

    /**
     * Get the options for the number of records to show per page.
     *
     * @return int|non-empty-array<int,int>
     */
    public function getPerPage(): int|array
    {
        return match (true) {
            \property_exists($this, 'perPage') && ! \is_null($this->perPage) => $this->perPage,
            \method_exists($this, 'perPage') => $this->perPage(),
            default => static::$defaultPerPageAmount
        };
    }

    /**
     * Get the paginator to use.
     * 
     * @return 'cursor'|'simple'|'length-aware'|class-string<\Illuminate\Contracts\Pagination\Paginator>|null
     */
    public function getPaginator(): ?string
    {
        return match (true) {
            \property_exists($this, 'paginator') && ! \is_null($this->paginator) => $this->paginator,
            \method_exists($this, 'paginator') => $this->paginator(),
            default => static::$defaultPaginator
        };
    }

    /**
     * Get the query parameter to use for the current page number being shown.
     */
    public function getPageKey(): ?string
    {
        return match (true) {
            \property_exists($this, 'page') && ! \is_null($this->page) => $this->page,
            \method_exists($this, 'page') => $this->page(),
            default => static::$pageKey
        };
    }

    /**
     * Get the query parameter to use for the number of records to show per page.
     */
    public function getCountKey(): string
    {
        return match (true) {
            \property_exists($this, 'count') && ! \is_null($this->count) => $this->count,
            \method_exists($this, 'count') => $this->count(),
            default => static::$countKey
        };
    }

    /**
     * Execute the query and paginate the results.
     * 
     * @throws \Honed\Table\Exceptions\InvalidPaginatorException
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Support\Collection
     */
    public function paginateRecords(Builder $query, Request $request = null): mixed
    {        
        $paginator = $this->getPaginator();

        $paginated = match (true) {
            \in_array($paginator, ['length-aware',
                LengthAwarePaginator::class,
                PaginationLengthAwarePaginator::class,
            ]) => $query->paginate(
                perPage: $this->getRecordsPerPage($request),
                pageName: $this->getPageKey(),
            ),
            \in_array($paginator, ['simple', Paginator::class]) => $query->simplePaginate(
                perPage: $this->getRecordsPerPage($request),
                pageName: $this->getPageKey(),
            ),
            \in_array($paginator, ['cursor', CursorPaginator::class, PaginationCursorPaginator::class]) => $query->cursorPaginate(
                perPage: $this->getRecordsPerPage($request),
                cursorName: $this->getPageKey(),
            ),
            \in_array($paginator, [null, 
                'none', 
                'collection', 
                Collection::class
            ]) => $query->get(),
            default => throw new InvalidPaginatorException($paginator),
        };

        return $paginated->withQueryString();
    }

    public function getRecordsPerPage(Request $request = null)
    {

    }
}
