<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Components\HasTooltip;
use Honed\Chart\Concerns\HasId;
use Illuminate\Support\Traits\ForwardsCalls;

class Toolbox extends Chartable
{
    use CanBeShown;
    use ForwardsCalls;
    use HasId;
    use HasTooltip;

    /**
     * @var array<string, mixed>|null
     */
    protected $feature;

    /**
     * @param  array<string, mixed>  $feature
     * @return $this
     */
    public function feature(array $feature): static
    {
        $this->feature = $feature;

        return $this;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getFeature(): ?array
    {
        return $this->feature;
    }

    /**
     * Get the representation of the toolbox.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'feature' => $this->getFeature(),
            // 'orient' => $this->getOrientation(),
            // 'itemSize' => $this->getItemSize(),
            // 'itemGap' => $this->getItemGap(),
            // 'showTitle' => $this->isShowTitle(),
            // 'iconStyle' => $this->getIconStyle()?->toArray(),
            // 'emphasis' => $this->getEmphasis()?->toArray(),
            // 'zLevel' => $this->getZLevel(),
            // 'z' => $this->getZ(),
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
