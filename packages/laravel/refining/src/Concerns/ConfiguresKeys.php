<?php

declare(strict_types=1);

namespace Honed\Refining\Concerns;

trait ConfiguresKeys
{
    protected string $sortKey = 'sort';
    protected string $searchKey = 'search';

    /**
     * Sets the sort key to look for in the request.
     */
    public function sortKey(string $sortKey): static
    {
        $this->sortKey = $sortKey;

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
     * Gets the sort key to look for in the request.
     */
    public function getSortKey(): string
    {
        return $this->sortKey;
    }

    /**
     * Gets the search key to look for in the request.
     */
    public function getSearchKey(): string
    {
        return $this->searchKey;
    }
}