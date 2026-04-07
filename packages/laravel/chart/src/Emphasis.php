<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\Components\HasAreaStyle;
use Honed\Chart\Concerns\Components\HasItemStyle;
use Honed\Chart\Concerns\Components\HasLabelLine;
use Honed\Chart\Concerns\Components\HasLineStyle;
use Honed\Chart\Concerns\Emphasis\HasDisabled;
use Honed\Chart\Concerns\Emphasis\HasEmphasisBlurScope;
use Honed\Chart\Concerns\Emphasis\HasEmphasisFocus;
use Honed\Chart\Concerns\Emphasis\HasScale;
use Honed\Chart\Concerns\HasLabel;
use Honed\Chart\Concerns\Proxies\Proxyable;
use Honed\Chart\Proxies\HigherOrderAreaStyle;
use Honed\Chart\Proxies\HigherOrderItemStyle;
use Honed\Chart\Proxies\HigherOrderLabel;
use Honed\Chart\Proxies\HigherOrderLabelLine;
use Honed\Chart\Proxies\HigherOrderLineStyle;

class Emphasis extends Chartable
{
    use HasAreaStyle;
    use HasDisabled;
    use HasEmphasisBlurScope;
    use HasEmphasisFocus;
    use HasItemStyle;
    use HasLabel;
    use HasLabelLine;
    use HasLineStyle;
    use HasScale;
    use Proxyable;

    public function __get(string $name): mixed
    {
        return match ($name) {
            'label' => new HigherOrderLabel($this, $this->withLabel()),
            'labelLine' => new HigherOrderLabelLine($this, $this->withLabelLine()),
            'itemStyle' => new HigherOrderItemStyle($this, $this->withItemStyle()),
            'lineStyle' => new HigherOrderLineStyle($this, $this->withLineStyle()),
            'areaStyle' => new HigherOrderAreaStyle($this, $this->withAreaStyle()),
            default => $this->defaultGet($name),
        };
    }

    /**
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'disabled' => $this->getDisabled(),
            'scale' => $this->getScale(),
            'scaleSize' => $this->getScaleSize(),
            'focus' => $this->getEmphasisFocus()?->value,
            'blurScope' => $this->getEmphasisBlurScope()?->value,
            'label' => $this->getLabel()?->toArray(),
            'labelLine' => $this->getLabelLine()?->toArray(),
            'itemStyle' => $this->getItemStyle()?->toArray(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
            'areaStyle' => $this->getAreaStyle()?->toArray(),
        ];
    }
}
