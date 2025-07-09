<?php

declare(strict_types=1);

namespace Honed\Infolist\Concerns;

use Honed\Infolist\Entries\BaseEntry;
use Honed\Infolist\Entries\Entry;

trait HasEntries
{
    /**
     * The entries of the list.
     *
     * @var array<int, BaseEntry>
     */
    protected $entries = [];

    /**
     * Merge a set of entries into the list.
     *
     * @param  BaseEntry|array<int, BaseEntry>  $entries
     * @return $this
     */
    public function entries($entries): static
    {
        /** @var array<int, BaseEntry> */
        $entries = is_array($entries) ? $entries : func_get_args();

        $this->entries = [...$this->entries, ...$entries];

        return $this;
    }

    /**
     * Add an entry to the list.
     *
     * @param  BaseEntry  $entry
     * @return $this
     */
    public function entry($entry): static
    {
        $this->entries[] = $entry;

        return $this;
    }

    /**
     * Get the entries of the list.
     *
     * @return array<int, BaseEntry>
     */
    public function getEntries(): array
    {
        return array_values(
            array_filter(
                $this->entries,
                fn (BaseEntry $entry) => $entry->isAllowed()
            )
        );
    }

    /**
     * Get the entries of the list as an array.
     *
     * @return array<int, array<string, mixed>>
     */
    public function entriesToArray(): array
    {
        return array_map(
            fn (BaseEntry $entry) => $entry->toArray(),
            $this->getEntries()
        );
    }
}
