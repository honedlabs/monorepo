<?php

declare(strict_types=1);

namespace Honed\List\Concerns;

use Honed\List\Entry;

trait HasEntries
{
    /**
     * The entries of the list.
     *
     * @var array<int, \Honed\List\Entries\Entry>
     */
    protected array $entries = [];

    /**
     * Merge a set of entries into the list.
     *
     * @param  \Honed\List\Entry\Entry|array<int, \Honed\List\Entries\Entry>  $entries
     * @return $this
     */
    public function entries(array|Entry $entries): self
    {
        $entries = is_array($entries) ? $entries : [$entries];

        $this->entries = [...$this->entries, ...$entries];

        return $this;
    }

    /**
     * Add an entry to the list.
     *
     * @param  \Honed\List\Entry\Entry  $entry
     * @return $this
     */
    public function entry(Entry $entry): self
    {
        $this->entries[] = $entry;

        return $this;
    }

    /**
     * Get the entries of the list.
     * 
     * @return array<int, \Honed\List\Entries\Entry>
     */
    public function getEntries(): array
    {
        return array_values(
            array_filter(
                $this->entries,
                fn (Entry $entry) => $entry->isAllowed()
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
            fn (Entry $entry) => $entry->toArray(),
            $this->getEntries()
        );
    }
}