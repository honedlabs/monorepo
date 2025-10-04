<?php

declare(strict_types=1);

namespace Honed\Infolist\Concerns;

use Honed\Infolist\Contracts\Entryable;

trait HasEntryables
{
    /**
     * The entries of the list.
     *
     * @var array<int, Entryable>
     */
    protected $entries = [];

    /**
     * Merge a set of entries into the list.
     *
     * @param  Entryable|array<int, Entryable>  $entries
     * @return $this
     */
    public function entries(Entryable|array $entries): static
    {
        /** @var array<int, Entryable> */
        $entries = is_array($entries) ? $entries : func_get_args();

        $this->entries = [...$this->entries, ...$entries];

        return $this;
    }

    /**
     * Add an entry to the list.
     *
     * @return $this
     */
    public function entry(Entryable $entry): static
    {
        $this->entries[] = $entry;

        return $this;
    }

    /**
     * Get the entries of the list.
     *
     * @return array<int, Entryable>
     */
    public function getEntries(): array
    {
        return array_values(
            array_filter(
                $this->entries,
                static fn (Entryable $entry) => $entry->isAllowed()
            )
        );
    }
}
