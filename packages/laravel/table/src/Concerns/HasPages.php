<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\PageAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Honed\Table\Exceptions\InvalidPaginatorException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\CursorPaginator as PaginationCursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;

trait HasPages
{
    /**
     * @var \Illuminate\Support\Collection<int,\Honed\Table\PageAmount>|null
     */
    protected $pages;

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
            default => $this->getDefaultPerPageAmount()
        };
    }

    /**
     * Get default per page amount.
     */
    public function getDefaultPerPage(): int
    {
        return match (true) {
            \property_exists($this, 'defaultPerPage') && ! \is_null($this->defaultPerPage) => $this->defaultPerPage,
            \method_exists($this, 'defaultPerPage') => $this->defaultPerPage(),
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
     * Retrieve the records to use for pagination for the given request, setting the page options if applicable.
     */
    public function getRecordsPerPage(Request $request = null): int
    {
        $amounts = $this->getPerPage();
    
        if (!\is_array($amounts)) {
            return $amounts;
        }
    
        $amount = ($request ?? request())
            ->input($this->getCountKey(), null);
    

        $amount = match (true) {
            ! \is_numeric($amount) || ! \in_array((int) $amount, $amounts) => $this->getDefaultPerPage(),
            default => (int) $amount,
        };

        $this->setPages(collect($amounts)
            ->map(static fn (int $perPage) => PageAmount::make($perPage, $perPage === $amount)));        
    
        return $amount;
    }

    /**
     * Set the page amount options quietly.
     * 
     * @param \Illuminate\Support\Collection<int,\Honed\Table\PageAmount> $pages
     */
    public function setPages(Collection $pages): void
    {
        $this->pages = $pages;
    }

    /**
     * Get the page amount options.
     * 
     * @return \Illuminate\Support\Collection<int,\Honed\Table\PageAmount>|null
     */
    public function getPages(): ?Collection
    {
        return $this->pages;
    }

    /**
     * Determine if the page amount options have been set.
     */
    public function hasPages(): bool
    {
        return ! \is_null($this->pages);
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
}
