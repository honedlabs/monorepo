<?php

declare(strict_types=1);

namespace Honed\Stat;

use Honed\Core\Primitive;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasLabel;
use Honed\Stat\Concerns\CanGroup;
use Honed\Stat\Concerns\HasData;
use Inertia\Inertia;

class Stat
{
    use HasName;
    use HasLabel;
    use HasData;
    use CanGroup;

    /**
     * Create a new stat instance.
     */
    public static function make(string $name, ?string $label = null)
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