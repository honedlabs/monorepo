<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\AxisPointerLabel\HasFormatter;
use Honed\Chart\Concerns\AxisPointerLabel\HasPointerMargin;
use Honed\Chart\Concerns\AxisPointerLabel\HasPrecision;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Components\HasTextStyle;
use Honed\Chart\Concerns\Proxies\Proxyable;
use Honed\Chart\Concerns\Style\HasBackgroundColor;
use Honed\Chart\Concerns\Style\HasBorderColor;
use Honed\Chart\Concerns\Style\HasBorderWidth;
use Honed\Chart\Proxies\HigherOrderTextStyle;

/**
 * @property-read HigherOrderTextStyle<static> $textStyle
 */
class AxisPointerLabel extends Chartable
{
    use CanBeShown;
    use HasBackgroundColor;
    use HasBorderColor;
    use HasBorderWidth;
    use HasFormatter;
    use HasPointerMargin;
    use HasPrecision;
    use HasTextStyle;
    use Proxyable;

    /**
     * Get a property of the axis pointer label.
     *
     * @param  non-empty-string  $name
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'textStyle' => new HigherOrderTextStyle($this, $this->withTextStyle()),
            default => $this->defaultGet($name),
        };
    }

    /**
     * Get the array representation of the axis pointer label.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'precision' => $this->getPrecision(),
            'formatter' => $this->getFormatter(),
            'margin' => $this->getPointerMargin(),
            'backgroundColor' => $this->getBackgroundColor(),
            'borderColor' => $this->getBorderColor(),
            'borderWidth' => $this->getBorderWidth(),
            'textStyle' => $this->getTextStyle()?->toArray(),
        ];
    }
}
