<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

use Closure;
use Honed\Refine\Searches\Search;

trait Searchable
{
    /**
     * The searchable of the instance.
     *
     * @var bool|string|Closure
     */
    protected $searchable = false;

    /**
     * Set the instance to be searchable.
     *
     * @param  bool|string|Closure  $value
     * @return $this
     */
    public function searchable(bool|string|Closure $value = true): static
    {
        $this->searchable = $value;

        return $this;
    }

    /**
     * Set the instance to not be searchable.
     *
     * @param  bool  $value
     * @return $this
     */
    public function notSearchable(bool $value = true): static
    {
        return $this->searchable(! $value);
    }

    /**
     * Determine if the instance is searchable.
     *
     * @return bool
     */
    public function isSearchable(): bool
    {
        return (bool) $this->searchable;
    }

    /**
     * Determine if the instance is not searchable.
     *
     * @return bool
     */
    public function isNotSearchable(): bool
    {
        return ! $this->isSearchable();
    }

    /**
     * Get the search instance.
     *
     * @return Search|null
     */
    public function getSearch(): ?Search
    {
        if (! $this->searchable) {
            return null;
        }

        return match (true) {
            $this->searchable instanceof Closure => $this->newSearch()->query($this->searchable),
            is_string($this->searchable) => $this->newSearch($this->searchable),
            default => $this->newSearch()
        };
    }

    /**
     * Create a new search instance.
     *
     * @param  string|null  $name
     * @return Search
     */
    protected function newSearch(?string $name = null): Search
    {
        /** @var string */
        $name = $name ?? $this->getName();

        return Search::make($name, $this->getLabel())
            ->alias($this->getAlias())
            ->qualify($this->getQualifier());
    }
}
