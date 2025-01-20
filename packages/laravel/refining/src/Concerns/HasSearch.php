<?php

declare(strict_types=1);

namespace Honed\Refining\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;

trait HasSearch
{
    /**
     * @var array<int,\Honed\Refining\Searches\Search>
     */
    protected $searches;

    protected string $searchKey = 'search';

    /** Allow for only certain columns to be used for searching */
    protected string $onlyOnKey = 'columns';

    /**
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
     * @return $this
     */
    public function search(Builder $builder, Request $request): static
    {
        $columns = ['name', 'description', 'values'];
        // $builder->where(function ($query) use ($columns) {
        //     $query->where(
        //         column: 'name',
        //         operator: 'like',
        //         value: '%test%',
        //         boolean: 'or'
        //     )
        // });
        foreach ($this->getSearches() as $search) {
            $search->value($columns)->apply($builder, $request);
        }

        return $this;
    }

    public function getProcessedParameter(Request $request): ?array
    {
        // Retrieve the raw query parameter value
        $rawValue = $request->query($this->parameterName);

        if (\is_null($rawValue)) {
            return null;
        }

        $processedArray = \array_filter(
            \array_map('trim', \explode(',', $rawValue)),
            fn ($value) => $value !== ''
        );

        return empty($processedArray) ? null : $processedArray;
    }
    
    /**
     * Sets the search key to look for in the request.
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
