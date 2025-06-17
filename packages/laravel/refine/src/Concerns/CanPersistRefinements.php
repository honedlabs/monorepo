<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Honed\Refine\Filters\Filter;

trait CanPersistRefinements
{
    use CanPersistData;

    /**
     * The driver to use for persisting search data.
     *
     * @var bool|string|null
     */
    protected bool|string|null $persistSearch = null;

    /**
     * The driver to use for persisting filter data.
     *
     * @var bool|string|null
     */
    protected bool|string|null $persistFilter = null;

    /**
     * The driver to use for persisting sort data.
     *
     * @var bool|string|null
     */
    protected bool|string|null $persistSort = null;

    /**
     * Set the driver to use for persisting searches.
     *
     * @param  bool|string|null  $driver
     * @return $this
     */
    public function persistSearch(bool|string $driver = true): self
    {
        $this->persistSearch = $driver;

        return $this;
    }

    /**
     * Set the session driver to be used for persisting searches.
     *
     * @return $this
     */
    public function persistSearchInSession(): self
    {
        return $this->persistSearch('session');
    }

    /**
     * Set the cookie driver to be used for persisting searches.
     *
     * @return $this
     */
    public function persistSearchInCookie(): self
    {
        return $this->persistSearch('cookie');
    }

    /**
     * Set the driver to use for persisting filters.
     *
     * @return $this
     */
    public function persistFilter(bool|string $driver = true): self
    {
        $this->persistSearch = $driver;

        return $this;
    }

    /**
     * Set the session driver to be used for persisting filters.
     *
     * @return $this
     */
    public function persistFilterInSession(): self
    {
        return $this->persistFilter('session');
    }

    /**
     * Set the cookie driver to be used for persisting filters.
     *
     * @return $this
     */
    public function persistFilterInCookie(): self
    {
        return $this->persistFilter('cookie');
    }

    /**
     * Set the driver to use for persisting sorts.
     *
     * @return $this
     */
    public function persistSort(bool|string $driver = true): self
    {
        $this->persistSort = $driver;

        return $this;
    }

    /**
     * Set the session driver to be used for persisting sorts.
     *
     * @return $this
     */
    public function persistSortInSession(): self
    {
        return $this->persistSort('session');
    }

    /**
     * Set the cookie driver to be used for persisting sorts.
     *
     * @return $this
     */
    public function persistSortInCookie(): self
    {
        return $this->persistSort('cookie');
    }

    /**
     * Set the driver to use for persisting all refinements.
     *
     * @return $this
     */
    public function persistent(bool|string $driver = true): self
    {
        $this->persistSearch = $driver;
        $this->persistFilter = $driver;
        $this->persistSort = $driver;

        return $this;
    }

    /**
     * Push a search value into the internal data store.
     */
    public function persistSearchValue(?string $term, ?array $columns = null): void
    {
        $this->getPersistDriver($this->persistSearch)
            ?->merge('search', 'term', $term);

        if ($columns) {
            $this->getPersistDriver($this->persistSearch)
                ?->merge('search', 'cols', $columns);
        }
    }

    /**
     * Get a filter value from the internal data store.
     *
     * @return array{string|null, array<int,string>|null}
     */
    public function getPersistedSearchValue(): array
    {
        $driver = $this->getPersistDriver($this->persistSearch);

        return [
            $driver?->get('search.term'),
            $driver?->get('search.cols'),
        ];
    }

    /**
     * Push a filter value into the internal data store.
     */
    public function persistFilterValue(Filter $filter, mixed $value): void
    {
        $this->getPersistDriver($this->persistFilter)
            ?->merge('filters', $filter->getParameter(), $value);
    }

    /**
     * Get a filter value from the internal data store.
     */
    public function getPersistedFilterValue(Filter $filter): mixed
    {
        return $this->getPersistDriver($this->persistFilter)
            ?->get('filters.'.$filter->getParameter());
    }

    /**
     * Push the sort value into the internal data store.
     *
     * @param  string  $column
     * @param  'asc'|'desc'|null  $direction
     * @return void
     */
    public function persistSortValue(string $column, ?string $direction = null): void
    {
        $this->getPersistDriver($this->persistFilter)
            ?->merge('sorts', 'col', $column)
            ->merge('sorts', 'dir', $direction);
    }

    /**
     * Get a sort value from the internal data store.
     *
     * @return array{string|null, 'asc'|'desc'|null}
     */
    public function getPersistedSortValue(): array
    {
        $driver = $this->getPersistDriver($this->persistSort);

        return [
            $driver?->get('sorts.col'),
            $driver?->get('sorts.dir'),
        ];
    }
}
