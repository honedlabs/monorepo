<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Searchable
{
    const SearchTerm = 'search';

    /**
     * The column names to use for searching.
     * 
     * @var string|array<int,string>
     */
    protected $search;

    /**
     * The name of the query parameter to use for searching.
     * 
     * @var string
     */
    protected $term;

    /**
     * The name of the query parameter to use for searching for all tables.
     * 
     * @var string
     */
    protected static $useTerm = self::SearchTerm;

    /**
     * Whether the table should use Laravel Scout for searching.
     * 
     * @var bool
     */
    protected $scout;

    /**
     * Whether the table should use Laravel Scout for searching for all tables.
     * 
     * @var bool
     */
    protected static $useScout = false;

    /**
     * Configure the default search query parameter to use for all tables.
     */
    public static function useSearchTerm(?string $term = null): void
    {
        static::$useTerm = $term ?? self::SearchTerm;
    }

    /**
     * Configure whether to enable Laravel Scout for searching of all tables by default.
     */
    public static function useScout(bool $scout = true): void
    {
        static::$useScout = $scout;
    }

    /**
     * Get the columns to use for searching.
     *
     * @return string|array<int,string>
     */
    public function getSearch(): string|array
    {
        return match (true) {
            \property_exists($this, 'search') && ! \is_null($this->search) => $this->search,
            \method_exists($this, 'search') => $this->search(),
            default => [],
        };
    }

    /**
     * Get the query parameter needed to identify the search term.
     */
    public function getSearchTerm(): string
    {
        return \property_exists($this, 'term') && ! \is_null($this->term)
            ? $this->term
            : static::$useTerm;
    }

    /**
     * Determine whether to use Laravel Scout for searching.
     */
    public function isScoutSearch(): bool
    {
        return (bool) (\property_exists($this, 'scout') && ! \is_null($this->scout)
            ? $this->scout
            : static::$useScout);
    }

    /**
     * Get the search term from the request query parameters.
     */
    public function getSearchParameters(Request $request = null): ?string
    {
        return ($request ?? request())->input($this->getSearchTerm(), null);
    }

    /**
     * Determine whether to apply searching if available.
     */
    public function isSearching(Request $request = null): bool
    {
        return \count($this->getSearch()) > 0 && (bool) $this->getSearchParameters($request);
    }

    /**
     * Apply the search to the builder.
     */
    public function searchQuery(Builder $builder, Request $request = null): void
    {
        $term = $this->getSearchParameters($request);

        if (\count($this->getSearch()) === 0 || ! (bool) $term) {
            return;
        }

        if ($this->isScoutSearch()) {
            // @phpstan-ignore-next-line
            $builder->search($term);

            return;
        }

        $builder->whereAny(
            (array) $this->getSearch(),
            'LIKE',
            "%{$term}%"
        );
    }
}
