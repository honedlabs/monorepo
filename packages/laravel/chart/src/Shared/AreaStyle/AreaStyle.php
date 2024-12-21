<?php

namespace Conquest\Chart\Shared\AreaStyle;

use Conquest\Chart\Shared\Concerns\Styling\HasColor;
use Conquest\Chart\Shared\Concerns\Styling\HasOpacity;
use Conquest\Chart\Shared\Concerns\Styling\HasOrigin;
use Conquest\Chart\Shared\Concerns\Styling\HasShadowBlur;
use Conquest\Chart\Shared\Concerns\Styling\HasShadowColor;
use Conquest\Chart\Shared\Concerns\Styling\HasShadowOffsetX;
use Conquest\Chart\Shared\Concerns\Styling\HasShadowOffsetY;
use Conquest\Core\Primitive;

class AreaStyle extends Primitive
{
    use HasColor;
    use HasOpacity;
    use HasOrigin;
    use HasShadowBlur;
    use HasShadowColor;
    use HasShadowOffsetX;
    use HasShadowOffsetY;

    public function __construct(
        ?string $color = null,
        ?string $origin = null
    ) {
        parent::__construct();
        $this->setColor($color);
        $this->setOrigin($origin);
    }

    public static function make()
    {
        return resolve(static::class, func_get_args());

    }

    public function toArray(): array
    {
        // Only return the options that are set
        return array_filter([
            'color' => $this->getColor(),
            'origin' => $this->getOrigin(),
            'shadowBlur' => $this->getShadowBlur(),
            'shadowColor' => $this->getShadowColor(),
            'shadowOffsetX' => $this->getShadowOffsetX(),
            'shadowOffsetY' => $this->getShadowOffsetY(),
            'opacity' => $this->getOpacity(),
        ]);
    }

    public function shadow(
        ?int $shadowBlur = null,
        ?string $shadowColor = null,
        ?int $shadowOffsetX = null,
        ?int $shadowOffsetY = null
    ): self {
        $this->setShadowBlur($shadowBlur);
        $this->setShadowColor($shadowColor);
        $this->setShadowOffsetX($shadowOffsetX);
        $this->setShadowOffsetY($shadowOffsetY);

        return $this;
    }
}
