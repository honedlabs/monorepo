<?php

declare(strict_types=1);

namespace Honed\Chart\Legend;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Legend\Concerns\HasLegendType;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Legend extends Primitive implements NullsAsUndefined
{
    use HasId;
    use CanBeShown;
    use HasLegendType;
    use HasZAxis;

    /**
     * Get the representation of the legend.
     * 
     * @return array<string,mixed>
     */
    protected function representation(): array
    {
        return [
            'type' => $this->getType(),
            'id' => $this->getId(),
            'show' => $this->isShown(),
            ...$this->getZAxisParameters(),
        ];
    }
}