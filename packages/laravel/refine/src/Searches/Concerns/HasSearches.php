<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Refine\Search;
use Illuminate\Support\Arr;

use function array_filter;
use function array_map;
use function array_merge;
use function array_values;

trait HasSearches
{
    /**
     * Whether the searches should be applied.
     *
     * @var bool
     */
    protected $search = true;

    /**
     * List of the searches.
     *
     * @var array<int,Search>
     */
    protected $searches = [];

    /**
     * The query parameter to identify the search string.
     *
     * @var string
     */
    protected $searchKey = 'search';

    /**
     * Whether the search columns can be toggled.
     *
     * @var bool
     */
    protected $match = false;

    /**
     * The query parameter to identify the columns to search on.
     *
     * @var string
     */
    protected $matchKey = 'match';

    /**
     * The search term as a string without replacements.
     *
     * @var string|null
     */
    protected $term;

    /**
     * The placeholder to use for the search bar.
     *
     * @var string|null
     */
    protected $searchPlaceholder;

    /**
     * Set whether the searches should be applied.
     *
     * @param  bool  $enable
     * @return $this
     */
    public function searchable($enable = true)
    {
        $this->searchable = $enable;

        return $this;
    }

    /**
     * Set whether the searches should not be applied.
     * 
     * @param  bool  $searchable
     * @return $this
     */
    public function notSearchable($disable = true)
    {
        return $this->searchable(! $disable);
    }

    /**
     * Determine if the searches should be applied.
     *
     * @return bool
     */
    public function isSearchable()
    {
        return $this->searchable;
    }

    /**
     * Determine if the searches should not be applied.
     *
     * @return bool
     */
    public function isNotSearchable()
    {
        return ! $this->isSearchable();
    }

    /**
     * Merge a set of searches with the existing searches.
     *
     * @param  Search|iterable<int, Search>  ...$searches
     * @return $this
     */
    public function searches(...$searches)
    {
        /** @var array<int, Search> $searches */
        $searches = Arr::flatten($searches);

        $this->searches = array_merge($this->searches, $searches);

        return $this;
    }

    /**
     * Retrieve the columns to be used for searching.
     *
     * @return array<int,Search>
     */
    public function getSearches()
    {
        if ($this->isNotSearchable()) {
            return [];
        }

        return once(fn () => array_values(
            array_filter(
                $this->searches,
                static fn (Search $search) => $search->isAllowed()
            )
        ));
    }

    /**
     * Set the query parameter to identify the search string.
     *
     * @param  string  $searchKey
     * @return $this
     */
    public function searchKey($searchKey)
    {
        $this->searchKey = $searchKey;

        return $this;
    }

    /**
     * Get the query parameter to identify the search.
     *
     * @return string
     */
    public function getSearchKey()
    {
        return $this->formatScope($this->searchKey);
    }

    /**
     * Set the query parameter to identify the columns to search.
     *
     * @param  string  $matchKey
     * @return $this
     */
    public function matchKey($matchKey)
    {
        $this->matchKey = $matchKey;

        return $this;
    }

    /**
     * Get the query parameter to identify the columns to search.
     *
     * @return string
     */
    public function getMatchKey()
    {
        return $this->formatScope($this->matchKey);
    }

    /**
     * Set whether the search columns can be toggled.
     *
     * @param  bool  $match
     * @return $this
     */
    public function matchable($match = true)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * Determine if matching is enabled
     *
     * @return bool
     */
    public function isMatchable()
    {
        return $this->match;
    }

    /**
     * Set the search term.
     *
     * @param  string|null  $term
     * @return $this
     */
    public function term($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Retrieve the search value.
     *
     * @return string|null
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Determine if there is a search being applied.
     *
     * @return bool
     */
    public function isSearching()
    {
        return filled($this->getTerm());
    }

    /**
     * Get the searches as an array.
     *
     * @return array<int,array<string,mixed>>
     */
    public function searchesToArray()
    {
        if (! $this->isMatchable()) {
            return [];
        }

        return array_values(
            array_map(
                static fn (Search $search) => $search->toArray(),
                array_filter(
                    $this->getSearches(),
                    static fn (Search $search) => $search->isVisible()
                )
            )
        );
    }
}
