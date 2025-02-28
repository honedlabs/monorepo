<?php

declare(strict_types=1);

namespace Honed\Table\Concerns\Support;

trait HasPaginator
{
    /**
     * The paginator to use for the table.
     *
     * @var 'cursor'|'simple'|'length-aware'|'collection'|string|null
     */
    protected $paginator;

    /**
     * Retrieve the default paginator for the table.
     *
     * @return 'cursor'|'simple'|'length-aware'|'collection'|string
     */
    public function getPaginator()
    {
        if (isset($this->paginator)) {
            return $this->paginator;
        }

        return $this->getFallbackPaginator();
    }

    /**
     * Get the fallback paginator for the table.
     *
     * @return 'cursor'|'simple'|'length-aware'|'collection'|string
     */
    protected function getFallbackPaginator()
    {
        return type(config('table.paginator', 'length-aware'))->asString();
    }

    /**
     * Determine if the paginator is a length-aware paginator.
     * 
     * @param string
     * @return bool
     */
    protected static function isLengthAware($paginator)
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
     * @param string
     * @return bool
     */
    protected static function isSimple($paginator)
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
     * @param string
     * @return bool
     */
    protected static function isCursor($paginator)
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
     * @param string
     * @return bool
     */
    protected static function isCollection($paginator)
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
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     * @return array<string, mixed>
     */
    protected static function lengthAwarePaginator($paginator)
    {
        return \array_merge(static::simplePaginator($paginator), [
            'total' => $paginator->total(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'firstLink' => $paginator->url(1),
            'lastLink' => $paginator->url($paginator->lastPage()),
            'links' => static::createPaginatorLinks($paginator),
        ]);
    }

    /**
     * Create pagination links with a sliding window around the current page.
     *
     * @param  \Illuminate\Contracts\Pagination\LengthAwarePaginator  $paginator
     * @return array<int, array<string, mixed>>
     */
    protected static function createPaginatorLinks($paginator)
    {
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $onEachSide = 2;
        
        // Calculate window boundaries with balanced distribution
        $start = max(1, min($currentPage - $onEachSide, $lastPage - ($onEachSide * 2)));
        $end = min($lastPage, max($currentPage + $onEachSide, ($onEachSide * 2 + 1)));
        
        return collect(range($start, $end))
            ->map(static fn ($page) => [
                'url' => $paginator->url($page),
                'label' => (string) $page,
                'active' => $currentPage === $page,
            ])
            ->values()
            ->all();
    }

    /**
     * Get the pagination data for the simple paginator.
     * 
     * @param \Illuminate\Contracts\Pagination\Paginator $paginator
     * @return array<string, mixed>
     */
    protected static function simplePaginator($paginator)
    {
        return \array_merge(static::cursorPaginator($paginator), [
            'currentPage' => $paginator->currentPage(),
        ]);
    }

    /**
     * Get the pagination data for the cursor paginator.
     * 
     * @param \Illuminate\Pagination\AbstractCursorPaginator|\Illuminate\Contracts\Pagination\Paginator $paginator
     * @return array<string, mixed>
     */
    protected static function cursorPaginator($paginator)
    {
        return \array_merge(static::collectionPaginator($paginator), [
            'prevLink' => $paginator->previousPageUrl(),
            'nextLink' => $paginator->nextPageUrl(),
            'perPage' => $paginator->perPage(),
        ]);
    }

    /**
     * Get the base metadata for the collection paginator, and all others.
     * 
     * @param \Illuminate\Support\Collection|\Illuminate\Pagination\AbstractCursorPaginator|\Illuminate\Contracts\Pagination\Paginator $paginator
     * @return array<string, mixed>
     */
    protected static function collectionPaginator($paginator)
    {
        return [
            'empty' => $paginator->isEmpty(),
        ];
    }
}
