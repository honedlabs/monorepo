<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Chart\Style\Concerns\HasBorderType;
use Honed\Chart\Style\Concerns\HasCap;
use Honed\Chart\Style\Concerns\HasColor;
use Honed\Chart\Style\Concerns\HasDashOffset;
use Honed\Chart\Style\Concerns\HasJoin;
use Honed\Chart\Style\Concerns\HasOpacity;
use Honed\Chart\Style\Concerns\HasShadowBlur;
use Honed\Chart\Style\Concerns\HasShadowColor;
use Honed\Chart\Style\Concerns\HasShadowOffset;
use Honed\Chart\Style\Concerns\HasWidth;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class LineStyle extends Primitive implements NullsAsUndefined
{
    use HasBorderType;
    use HasCap;
    use HasColor;
    use HasDashOffset;
    use HasJoin;
    use HasOpacity;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;
    use HasWidth;

    /**
     * Create a new line style instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the representation of the line style.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'color' => $this->getColor(),
            'width' => $this->getWidth(),
            'type' => $this->getBorderType(),
            'dashOffset' => $this->getDashOffset(),
            'cap' => $this->getCap(),
            'join' => $this->getJoin(),
            'miterLimit' => $this->getMiterLimit(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowColor' => $this->getShadowColor(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            'opacity' => $this->getOpacity(),
            // 'inactiveColor' => $this->getInactiveColor(),
            // 'inactiveWidth' => $this->getInactiveWidth(),
        ];
    }
}
