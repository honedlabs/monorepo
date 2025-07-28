<?php

declare(strict_types=1);

namespace Honed\Chart\Toolbox;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Tooltip\Concerns\HasTrigger;
use Honed\Core\Primitive;

class Toolbox extends Primitive
{
    use CanBeShown;
    use HasTrigger;

    /**
     * Create a new tooltip instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the representation of the tooltip.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
        ];
    }

}