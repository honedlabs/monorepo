<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

class Entry extends BaseEntry
{
    use Concerns\CanBeAggregated;

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray()
    {
        return [
            ...parent::toArray(),
            'shape' => $this->getShape(),
        ];
    }
}
