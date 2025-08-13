<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Chart\Style\Concerns\HasColor;
use Honed\Chart\Style\Concerns\HasOpacity;
use Honed\Chart\Style\Concerns\HasShadowBlur;
use Honed\Chart\Style\Concerns\HasShadowOffset;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class ShadowStyle extends Primitive implements NullsAsUndefined
{
    use HasColor;
    use HasOpacity;
    use HasShadowBlur;
    use HasShadowOffset;

    /**
     * Create a new shadow style instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the array representation of the shadow style.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'color' => $this->getColor(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            'opacity' => $this->getOpacity(),
        ];
    }
}
