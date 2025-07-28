<?php

declare(strict_types=1);

namespace Honed\Chart\Toolbox;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasOrientation;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Toolbox extends Primitive implements NullsAsUndefined
{
    use HasId;
    use CanBeShown;
    use HasZAxis;
    use HasOrientation;

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
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'orient' => $this->getOrientation(),
            ...$this->getZAxisParameters(),
        ];
    }

}