<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Polar;

use Honed\Chart\Axis\Axis;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Polar extends Primitive implements NullsAsUndefined
{
    use HasId;
    use HasZAxis;
    
    /**
     * Get the representation of the polar coordinate.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'id' => $this->getId(),
            'z' => $this->getZ(),
            'zLevel' => $this->getZLevel(),
        ];
    }
    
}