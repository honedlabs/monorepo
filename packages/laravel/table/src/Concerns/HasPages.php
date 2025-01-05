<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Honed\Table\Exceptions\InvalidPaginatorException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
     * @var class-string|null
     */
    protected $paginator;

    /**
     * @var class-string|null
     */
    protected static $defaultPaginator = LengthAwarePaginator::class;

    /**
     * @var string
     */
    protected $page;

    /**
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
     * Configure the options for the number of items to show per page.
     *
     * @param  int|array<int,int>  $perPage
     */
    public static function recordsPerPage(int|array $perPage): void
    {
        static::$defaultPerPageAmount = $perPage;
    }

    /**
     * Configure the default paginator to use.
     *
     * @param  string|\Honed\Table\Enums\Paginator  $paginator
     */
    public static function usePaginator(string|Paginator $paginator): void
    {
        static::$defaultPaginator = $paginator;
    }

    /**
     * Configure the query parameter to use for the page number.
     */
    public static function usePageKey(string $name): void
    {
        static::$pageKey = $name;
    }

    /**
     * Get the options for the number of items to show per page.
     *
     * @return int|non-empty-array<int,int>
     */
    public function getPerPage(): int|array
    {
        return match (true) {
            \property_exists($this, 'perPage') => $this->perPage,
            \method_exists($this, 'perPage') => $this->perPage(),
            default => static::$defaultPerPageAmount
        };
    }

    /**
     * Get the default paginator to use.
     *
     * @return class-string|null
     */
    public function getPaginator(): string|null
    {
        return match (true) {
            \property_exists($this, 'paginator') => $this->paginator,
            \method_exists($this, 'paginator') => $this->paginator(),
            default => static::$defaultPaginator
        };
    }

    /**
     * Get the query parameter to use for the page number.
     */
    public function getPageKey(): string
    {
        return match (true) {
            \property_exists($this, 'page') => $this->page,
            default => static::$pageKey
        };
    }

    /**
     * Get the query parameter to use for the number of items to show.
     */
    public function getCountKey(): string
    {
        return match (true) {
            \property_exists($this, 'count') => $this->count,
            \method_exists($this, 'count') => $this->count(),
            default => static::$countKey
        };
    }

    /**
     * Get the pagination options for the number of items to show per page.
     *
     * @return array<int,array{value:int,active:bool}>
     */
    public function getPaginationCounts(int|null $active = null): array
    {
        $perPage = $this->getRecordsPerPage();

        return is_array($perPage)
            ? array_map(fn ($count) => ['value' => $count, 'active' => $count === $active], $perPage)
            : [['value' => $perPage, 'active' => true]];
    }

    public function getRecordsPerPage(): int|false
    {
        $request = request();

        if (\is_null($this->getPaginator())) {
            return false;
        }

        // Only an array can have pagination options, so short circuit if not an array
        if (! \is_array($this->getPerPage())) {
            return $this->getPerPage();
        }

        // Force integer
        $fromRequest = $request->integer($this->getPerPageName());

        // Loop over the options to create a serializable array

        // Must ensure the query param is in the array to prevent abuse of 1000s of records

        // 0 indicates no term is provided, so use the first option
        if ($fromRequest === 0) {
            return $this->getPerPage()[0];
        }

        return $this->getPerPage();
    }

    /**
     * Execute the query and paginate the results.
     */
    public function paginateRecords(Builder $query): Paginator|CursorPaginator|Collection
    {
        $paginator = match ($this->getPaginator()) {
            LengthAwarePaginator::class => $query->paginate(
                perPage: $this->getRecordsPerPage(),
                pageName: $this->getPageKey(),
            ),
            Paginator::class => $query->simplePaginate(
                perPage: $this->getRecordsPerPage(),
                pageName: $this->getPageKey(),
            ),
            CursorPaginator::class => $query->cursorPaginate(
                perPage: $this->getRecordsPerPage(),
                cursorName: $this->getPageKey(),
            ),
            null => $query->get(),
            default => throw new InvalidPaginatorException($this->getPaginator()),
        };

        return $paginator->withQueryString();
    }
}
