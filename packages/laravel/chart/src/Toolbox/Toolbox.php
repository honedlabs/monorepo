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
    use CanBeShown;
    use HasId;
    use HasOrientation;
    use HasZAxis;

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
            // 'itemSize' => $this->getItemSize(),
            // 'itemGap' => $this->getItemGap(),
            // 'showTitle' => $this->isShowTitle(),
            // 'feature'
            // 'iconStyle' => $this->getIconStyle()?->toArray(),
            // 'emphasis' => $this->getEmphasis()?->toArray(),
            'zLevel' => $this->getZLevel(),
            'z' => $this->getZ(),
            // 'left' => $this->getLeft(),
            // 'top' => $this->getTop(),
            // 'right' => $this->getRight(),
            // 'bottom' => $this->getBottom(),
            // 'width' => $this->getWidth(),
            // 'height' => $this->getHeight(),
            // 'tooltip' => $this->getTooltip()?->toArray(),
        ];
    }
}
