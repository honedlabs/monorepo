<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Chart\Style\Concerns\HasBorderColor;
use Honed\Chart\Style\Concerns\HasBorderRadius;
use Honed\Chart\Style\Concerns\HasBorderType;
use Honed\Chart\Style\Concerns\HasBorderWidth;
use Honed\Chart\Style\Concerns\HasCap;
use Honed\Chart\Style\Concerns\HasColor;
use Honed\Chart\Style\Concerns\HasDashOffset;
use Honed\Chart\Style\Concerns\HasJoin;
use Honed\Chart\Style\Concerns\HasOpacity;
use Honed\Chart\Style\Concerns\HasShadowBlur;
use Honed\Chart\Style\Concerns\HasShadowColor;
use Honed\Chart\Style\Concerns\HasShadowOffset;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class ItemStyle extends Primitive implements NullsAsUndefined
{
    use HasBorderColor;
    use HasBorderRadius;
    use HasBorderType;
    use HasBorderWidth;
    use HasCap;
    use HasColor;
    use HasDashOffset;
    use HasJoin;
    use HasOpacity;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;

    /**
     * Create a new item style instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the representation of the item style.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'color' => $this->getColor(),
            'borderColor' => $this->getBorderColor(),
            'borderWidth' => $this->getBorderWidth(),
            'borderType' => $this->getBorderType(),
            'borderDashOffset' => $this->getDashOffset(),
            'borderCap' => $this->getCap(),
            'borderJoin' => $this->getJoin(),
            'borderMiterLimit' => $this->getMiterLimit(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowColor' => $this->getShadowColor(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            'opacity' => $this->getOpacity(),
            'borderRadius' => $this->getBorderRadius(),
            // 'decal' => $this->getDecal(),
        ];
    }
}
