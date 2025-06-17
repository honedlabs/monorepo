<?php

declare(strict_types=1);

namespace Honed\Refine\Searches\Concerns;

use function array_map;
use Honed\Core\Interpret;

use function array_filter;
use function array_values;
use Illuminate\Http\Request;
use Honed\Refine\Searches\Search;

trait HasSearches
{
    /**
     * Whether the searches should be applied.
     *
     * @var bool
     */
    protected bool $searchable = true;

    /**
     * Whether the search columns can be toggled.
     *
     * @var bool
     */
    protected bool $match = false;

    /**
     * Indicate whether to use Laravel Scout for searching.
     *
     * @var bool
     */
    protected bool $scout = false;

    /**
     * List of the searches.
     *
     * @var array<int,Search>
     */
    protected array $searches = [];

    /**
     * The query parameter to identify the search string.
     *
     * @var string
     */
    protected string $searchKey = 'search';

    /**
     * The query parameter to identify the columns to search on.
     *
     * @var string
     */
    protected string $matchKey = 'match';

    /**
     * The search term as a string without replacements.
     *
     * @var string|null
     */
    protected ?string $term = null;

    /**
     * The placeholder to use for the search bar.
     *
     * @var string|null
     */
    protected ?string $searchPlaceholder = null;

    /**
     * Set whether the searches should be applied.
     *
     * @param  bool  $enable
     * @return $this
     */
    public function searchable(bool $enable = true): self
    {
        $this->searchable = $enable;

        return $this;
    }

    /**
     * Set whether the searches should not be applied.
     *
     * @param  bool  $disable
     * @return $this
     */
    public function notSearchable(bool $disable = true): self
    {
        return $this->searchable(! $disable);
    }

    /**
     * Determine if the searches should be applied.
     *
     * @return bool
     */
    public function isSearchable(): bool
    {
        return $this->searchable;
    }

    /**
     * Determine if the searches should not be applied.
     *
     * @return bool
     */
    public function isNotSearchable(): bool
    {
        return ! $this->isSearchable();
    }

    /**
     * Set whether the search columns can be toggled.
     *
     * @param  bool  $enable
     * @return $this
     */
    public function matchable(bool $enable = true): self
    {
        $this->match = $enable;

        return $this;
    }

    /**
     * Set whether the search columns can not be toggled.
     *
     * @param  bool  $disable
     * @return $this
     */
    public function notMatchable(bool $disable = true): self
    {
        return $this->matchable(! $disable);
    }

    /**
     * Determine if matching is enabled
     *
     * @return bool
     */
    public function isMatchable(): bool
    {
        return $this->match && $this->isNotScout();
    }

    /**
     * Determine if matching is not enabled.
     *
     * @return bool
     */
    public function isNotMatchable(): bool
    {
        return ! $this->isMatchable();
    }

    /**
     * Set whether to use Laravel Scout for searching.
     *
     * @param  bool  $scout
     * @return $this
     */
    public function scout(bool $scout = true): self
    {
        $this->scout = $scout;

        return $this;
    }

    /**
     * Determine if Laravel Scout is being used for searching.
     *
     * @return bool
     */
    public function isScout(): bool
    {
        return $this->scout;
    }

    /**
     * Determine if Laravel Scout is not being used for searching.
     *
     * @return bool
     */
    public function isNotScout(): bool
    {
        return ! $this->isScout();
    }

    /**
     * Merge a set of searches with the existing searches.
     *
     * @param  Search|array<int, Search>  $searches
     * @return $this
     */
    public function searches(Search|array $searches): self
    {
        /** @var array<int, Search> $searches */
        $searches = is_array($searches) ? $searches : func_get_args();

        $this->searches = [...$this->searches, ...$searches];

        return $this;
    }

    /**
     * Retrieve the columns to be used for searching.
     *
     * @return array<int,Search>
     */
    public function getSearches(): array
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
    public function searchKey(string $searchKey): self
    {
        $this->searchKey = $searchKey;

        return $this;
    }

    /**
     * Get the query parameter to identify the search.
     *
     * @return string
     */
    public function getSearchKey(): string
    {
        return $this->formatScope($this->searchKey);
    }

    /**
     * Set the query parameter to identify the columns to search.
     *
     * @param  string  $matchKey
     * @return $this
     */
    public function matchKey(string $matchKey): self
    {
        $this->matchKey = $matchKey;

        return $this;
    }

    /**
     * Get the query parameter to identify the columns to search.
     *
     * @return string
     */
    public function getMatchKey(): string
    {
        return $this->formatScope($this->matchKey);
    }

    /**
     * Retrieve the search value.
     *
     * @return string|null
     */
    public function getTerm(): ?string
    {
        return $this->term;
    }

    /**
     * Set the placeholder text to use for the search bar.
     *
     * @param  string|null  $placeholder
     * @return $this
     */
    public function searchPlaceholder(?string $placeholder): self
    {
        $this->searchPlaceholder = $placeholder;

        return $this;
    }

    /**
     * Get the placeholder text to use for the search bar.
     *
     * @return string|null
     */
    public function getSearchPlaceholder(): ?string
    {
        return $this->searchPlaceholder;
    }

    /**
     * Determine if there is a search being applied.
     *
     * @return bool
     */
    public function isSearching(): bool
    {
        return filled($this->getTerm());
    }

    /**
     * Get the search value from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function getSearchValue(Request $request): ?string
    {
        $key = $this->getSearchKey();

        $term = Interpret::string($request, $key);

        if (! $term) {
            return null;
        }

        return str_replace('+', ' ', trim($term));
    }

    /**
     * Get the columns to search on from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<int,string>|null
     */
    public function getSearchColumns(Request $request): ?array
    {
        if ($this->isNotMatchable()) {
            return null;
        }

        $delimiter = $this->getDelimiter();

        $key = $this->getMatchKey();

        return Interpret::array($request, $key, $delimiter, 'string');
    }

    /**
     * Get the searches as an array.
     *
     * @return array<int,array<string,mixed>>
     */
    public function searchesToArray(): array
    {
        if ($this->isNotMatchable()) {
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
