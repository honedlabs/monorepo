<?php

declare(strict_types=1);

namespace Honed\Stats;

use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasName;
use Honed\Stats\Concerns\CanGroup;
use Honed\Stats\Concerns\HasData;

class Stat
{
    use CanGroup;
    use HasData;
    use HasLabel;
    use HasName;

    /**
     * Create a new stat instance.
     */
    public static function make(string $name, ?string $label = null): static
    {
        return resolve(static::class)
            ->name($name)
            ->label($label ?? static::makeLabel($name));
    }

    /**
     * Get the label.
     */
    public function getLabel(): ?string
    {
        /** @var string|null */
        return $this->label;
    }

    /**
     * Get the group of the data.
     */
    public function getGroup(): ?string
    {
        if (is_string($this->group)) {
            return $this->group;
        }

        return null;
    }
}
