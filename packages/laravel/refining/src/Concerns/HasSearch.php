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
        foreach ($this->getSearches() as $search) {
            $search->apply($builder, $this->getBuilder());
        }

        return $this;
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
