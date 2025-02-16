<?php

declare(strict_types=1);

namespace Honed\Nav;

use Illuminate\Support\Arr;

class NavGroup extends NavBase
{
    use Concerns\HasItems;

    /**
     * Create a new nav group instance.
     *
     * @param  array<int,mixed>  $items
     */
    public static function make(string $label, ...$items): static
    {
        return resolve(static::class)
            ->label($label)
            ->items(Arr::flatten($items));
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'items' => $this->itemsToArray(),
        ]);
    }
}
