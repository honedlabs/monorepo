<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Components\HasLineStyle;
use Honed\Chart\Concerns\LabelLine\HasLength;
use Honed\Chart\Concerns\LabelLine\HasLength2;
use Honed\Chart\Concerns\LabelLine\HasSmooth;
use Honed\Chart\Concerns\Proxies\Proxyable;
use Honed\Chart\Proxies\HigherOrderLineStyle;

/**
 * @property-read HigherOrderLineStyle<static> $lineStyle
 */
class LabelLine extends Chartable
{
    use CanBeShown;
    use HasLength;
    use HasLength2;
    use HasLineStyle;
    use HasSmooth;
    use Proxyable;

    /**
     * Get a property of the label line.
     *
     * @param  non-empty-string  $name
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'lineStyle' => new HigherOrderLineStyle($this, $this->withLineStyle()),
            default => $this->defaultGet($name),
        };
    }

    /**
     * Get the array representation of the label line.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'length' => $this->getLength(),
            'length2' => $this->getLength2(),
            'smooth' => $this->getSmooth(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
        ];
    }
}
