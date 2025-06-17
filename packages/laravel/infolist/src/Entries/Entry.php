<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

class Entry extends BaseEntry
{
    use Concerns\CanBeAggregated;

    /**
     * Get the instance as an array.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     * @return array<string, mixed>
     */
    public function toArray($named = [], $typed = [])
    {
        return [
            ...parent::toArray($named, $typed),
            'shape' => $this->getShape(),
        ];
    }
}
