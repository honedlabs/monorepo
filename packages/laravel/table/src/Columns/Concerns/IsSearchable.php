<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsSearchable
{
    /**
     * @var bool
     */
    protected $searchable = false;

    /**
     * Set the searchable property, chainable.
     *
     * @return $this
     */
    public function searchable(?bool $searchable = true): static
    {
        $this->setSearchable($searchable);

        return $this;
    }

    /**
     * Set the searchable property quietly.
     */
    public function setSearchable(bool $searchable): void
    {
        $this->searchable = $searchable;
    }

    /**
     * Determine if the column is searchable.
     */
    public function isSearchable(): bool
    {
        return $this->searchable;
    }
}
