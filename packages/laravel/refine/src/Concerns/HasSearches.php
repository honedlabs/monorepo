<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Refine\Concerns\Support\CanMatch;
use Honed\Refine\Concerns\Support\MatchesKey;
use Honed\Refine\Concerns\Support\SearchesKey;
use Honed\Refine\Searches\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

trait HasSearches
{
    use CanMatch;
    use MatchesKey;
    use SearchesKey;
    use AccessesRequest;

    /**
     * The query parameter to identify the search string.
     *
     * @var string|null
     */
    protected $searchesKey;

    /**
     * Whether the search columns can be toggled.
     *
     * @var bool|null
     */
    protected $match;

    /**
     * The query parameter to identify the columns to search on.
     *
     * @var string|null
     */
    protected $matchesKey;

    /**
     * The search term as a string without replacements.
     *
     * @var string|null
     */
    protected $term;

    /**
     * List of the searches.
     *
     * @var array<int,\Honed\Refine\Searches\Search>|null
     */
    protected $searches;

    /**
     * Set the query parameter to identify the search string.
     *
     * @return $this
     */
    public function searchesKey(string $searchesKey): static
    {
        $this->searchesKey = $searchesKey;

        return $this;
    }

    /**
     * Get the query parameter to identify the search string.
     */
    public function getSearchesKey(): string
    {
        if (isset($this->searchesKey)) {
            return $this->searchesKey;
        }

        return $this->getFallbackSearchesKey();
    }

    /**
     * Get the fallback query parameter to identify the search string.
     */
    protected function getFallbackSearchesKey(): string
    {
        return type(config('refine.config.searches', 'search'))->asString();
    }

    /**
     * Get the query parameter to identify the columns to search on.
     */
    public function getMatchesKey(): string
    {
        if (isset($this->matchesKey)) {
            return $this->matchesKey;
        }

        return $this->getFallbackMatchesKey();
    }

    /**
     * Get the fallback query parameter to identify the columns to search on.
     */
    protected function getFallbackMatchesKey(): string
    {
        return type(config('refine.config.matches', 'match'))->asString();
    }

    /**
     * Determine whether the search columns can be toggled.
     */
    public function canMatch(): bool
    {
        if (isset($this->match)) {
            return $this->match;
        }

        return $this->getFallbackCanMatch();
    }

    /**
     * Get the fallback value to determine whether the search columns can be toggled.
     */
    protected function getFallbackCanMatch(): bool
    {
        return (bool) config('refine.matches', false);
    }

    /**
     * Merge a set of searches with the existing searches.
     *
     * @param  array<int, \Honed\Refine\Searches\Search>|\Illuminate\Support\Collection<int, \Honed\Refine\Searches\Search>  $searches
     * @return $this
     */
    public function addSearches($searches): static
    {
        if ($searches instanceof Collection) {
            $searches = $searches->all();
        }

        $this->searches = \array_merge($this->searches ?? [], $searches);

        return $this;
    }

    /**
     * Add a single search to the list of searches.
     *
     * @return $this
     */
    public function addSearch(Search $search): static
    {
        $this->searches[] = $search;

        return $this;
    }

    /**
     * Retrieve the columns to be used for searching.
     *
     * @return array<int,\Honed\Refine\Searches\Search>
     */
    public function getSearches(): array
    {
        return once(function () {
            $methodSearches = method_exists($this, 'searches') ? $this->searches() : [];
            $propertySearches = $this->searches ?? [];

            return \array_values(
                \array_filter(
                    \array_merge($propertySearches, $methodSearches),
                    static fn (Search $search) => $search->isAllowed()
                )
            );
        });
    }

    /**
     * Determines if the instance has any searches.
     */
    public function hasSearch(): bool
    {
        return filled($this->getSearches());
    }

    /**
     * Apply a search to the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @return $this
     */
    public function search(Builder $builder): static
    {
        $columns = ($this->canMatch()
            ? $this->getArrayFromQueryParameter($this->getMatchesKey())
            : null) ?? true;

        $term = $this->getSearchTerm();

        $this->term = $term;

        $applied = false;

        foreach ($this->getSearches() as $search) {
            $boolean = $applied ? 'or' : 'and';

            $applied |= $search->apply($builder, $term, $columns, $boolean);
        }

        return $this;
    }

    /**
     * Get the search value from the request.
     */
    public function getSearchTerm(): ?string
    {
        $search = str($this->getQueryParameter($this->getSearchesKey()));

        if ($search->isEmpty()) {
            return null;
        }

        return $search
            ->replace('+', ' ')
            ->toString();
    }

    /**
     * Retrieve the search value.
     */
    public function getTerm(): ?string
    {
        return $this->term;
    }

    /**
     * Get the searches as an array.
     *
     * @return array<int,mixed>
     */
    public function searchesToArray(): array
    {
        return \array_map(
            static fn (Search $search) => $search->toArray(),
            $this->getSearches()
        );
    }
}
