<?php

declare(strict_types=1);

namespace Honed\Refining\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;

trait HasSearch
{
    const SearchKey = 'search';
    const ColumnsKey = 'columns';

    /**
     * Whether the search should consider the presence of the columns key in the request.
     * 
     * @var bool
     */
    protected $searchAll = false;

    /**
     * An array of the attributes to be used for searching.
     * 
     * @var array<int,\Honed\Refining\Searches\Search>
     */
    protected $searches;

    /**
     * The query parameter key to look for in the request for the search value.
     * 
     * @var string
     */
    protected $searchKey = self::SearchKey;

    /**
     * The query parameter key to look for in the request for the columns to be used for searching.
     * 
     * @var string
     */
    protected $columnsKey = self::ColumnsKey;

    /**
     * Define new columns to be used for searching.
     * 
     * @param iterable<\Honed\Refining\Searches\Search> $searches
     * @return $this
     */
    public function addSearches(iterable $searches): static
    {
        if ($searches instanceof Arrayable) {
            $searches = $searches->toArray();
        }

        $this->searches = \array_merge($this->searches, $searches);

        return $this;
    }

    /**
     * Retrieve the columns to be used for searching.
     * 
     * @return array<int,\Honed\Refining\Searches\Search>
     */
    public function getSearches(): array
    {
        return $this->searches ??= match (true) {
            \method_exists($this, 'searches') => $this->searches(),
            default => [],
        };
    }

    /**
     * Search the query.
     * 
     * @param \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $builder
     * @return $this
     */
    public function search(Builder $builder, Request $request): static
    {
        $columns = $this->getSearchesFromRequest($request);

        foreach ($this->getSearches() as $i => $search) {
            $search->apply(
                builder: $builder, 
                request: $request, 
                and: $i === 0,
                columns: $this->searchAll ? true : $columns,
            );
        }

        return $this;
    }

    // public function getProcessedParameter(Request $request): ?array
    // {
    //     // Retrieve the raw query parameter value
    //     $rawValue = $request->query($this->parameterName);

    //     if (\is_null($rawValue)) {
    //         return null;
    //     }

    //     $processedArray = \array_filter(
    //         \array_map('trim', \explode(',', $rawValue)),
    //         fn ($value) => $value !== ''
    //     );

    //     return empty($processedArray) ? null : $processedArray;
    // }
    
    /**
     * Sets the search key to look for in the request.
     * 
     * @return $this
     */
    public function searchKey(string $searchKey): static
    {
        $this->searchKey = $searchKey;

        return $this;
    }

    /**
     * Gets the search key to look for in the request.
     */
    public function getSearchKey(): string
    {
        return $this->searchKey;
    }
}
