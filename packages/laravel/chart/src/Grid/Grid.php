<?php

declare(strict_types=1);

namespace Honed\Chart\Grid;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\HasTooltip;
use Honed\Chart\Concerns\HasZAxis;
use Honed\Chart\Grid\Concerns\CanContainLabel;
use Honed\Chart\Style\Concerns\HasBackgroundColor;
use Honed\Chart\Style\Concerns\HasBorderColor;
use Honed\Chart\Style\Concerns\HasBorderWidth;
use Honed\Chart\Style\Concerns\HasBottom;
use Honed\Chart\Style\Concerns\HasHeight;
use Honed\Chart\Style\Concerns\HasLeft;
use Honed\Chart\Style\Concerns\HasRight;
use Honed\Chart\Style\Concerns\HasShadowBlur;
use Honed\Chart\Style\Concerns\HasShadowColor;
use Honed\Chart\Style\Concerns\HasShadowOffset;
use Honed\Chart\Style\Concerns\HasTop;
use Honed\Chart\Style\Concerns\HasWidth;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Grid extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    use CanContainLabel;
    use HasBackgroundColor;
    use HasBorderColor;
    use HasBorderWidth;
    use HasBottom;
    use HasHeight;
    use HasId;
    use HasLeft;
    use HasRight;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffset;
    use HasTooltip;
    use HasTop;
    use HasWidth;
    use HasZAxis;

    /**
     * Create a new grid instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the representation of the grid.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'zLevel' => $this->getZLevel(),
            'z' => $this->getZ(),
            'left' => $this->getLeft(),
            'top' => $this->getTop(),
            'right' => $this->getRight(),
            'bottom' => $this->getBottom(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'containLabel' => $this->isContainingLabel(),
            'backgroundColor' => $this->getBackgroundColor(),
            'borderColor' => $this->getBorderColor(),
            'borderWidth' => $this->getBorderWidth(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowColor' => $this->getShadowColor(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            'tooltip' => $this->getTooltip()?->toArray(),
        ];
    }
}
