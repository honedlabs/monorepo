<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\Proxies\Proxyable;
use Honed\Chart\Concerns\Style\HasBottom;
use Honed\Chart\Concerns\Style\HasHeight;
use Honed\Chart\Concerns\Style\HasInactiveBorderColor;
use Honed\Chart\Concerns\Style\HasInactiveColor;
use Honed\Chart\Concerns\Style\HasInactiveWidth;
use Honed\Chart\Concerns\Style\HasLeft;
use Honed\Chart\Concerns\Style\HasPadding;
use Honed\Chart\Concerns\Style\HasRight;
use Honed\Chart\Concerns\Style\HasTop;
use Honed\Chart\Concerns\Style\HasWidth;
use Honed\Chart\Concerns\Style\HasZ;
use Honed\Chart\Concerns\Style\HasZLevel;
use Honed\Chart\Enums\LegendType;
use TypeError;
use ValueError;

class Legend extends Chartable
{
    use CanBeShown;
    use HasBottom;
    use HasHeight;
    use HasId;
    use HasInactiveBorderColor;
    use HasInactiveColor;
    use HasInactiveWidth;
    use HasLeft;
    use HasPadding;
    use HasRight;
    use HasTop;
    use HasWidth;
    use HasZ;
    use HasZLevel;
    use Proxyable;

    /**
     * The type of legend.
     *
     * @var ?LegendType
     */
    protected $type;

    /**
     * Legend item names (`data` in ECharts).
     *
     * @var list<string>|null
     */
    protected $labels;

    /**
     * Get a property of the legend.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            // 'itemStyle' => new HigherOrderItemStyle($this, $this->withItemStyle()),
            // 'lineStyle' => new HigherOrderLineStyle($this, $this->withLineStyle()),
            // 'textStyle' => new HigherOrderTextStyle($this, $this->withTextStyle()),
            // 'emphasis' => new HigherOrderEmphasis($this, $this->withEmphasis()),
            default => $this->defaultGet($name),
        };
    }

    /**
     * Set the type of legend.
     *
     * @return $this
     *
     * @throws ValueError
     * @throws TypeError
     */
    public function type(string|LegendType $value): static
    {
        $this->type = is_string($value) ? LegendType::from($value) : $value;

        return $this;
    }

    /**
     * Set the type of legend to be plain.
     *
     * @return $this
     *
     * @throws ValueError
     * @throws TypeError
     */
    public function plain(): static
    {
        return $this->type(LegendType::Plain);
    }

    /**
     * Set the type of legend to be scroll.
     *
     * @return $this
     *
     * @throws ValueError
     * @throws TypeError
     */
    public function scroll(): static
    {
        return $this->type(LegendType::Scroll);
    }

    /**
     * Get the type of legend.
     */
    public function getType(): ?LegendType
    {
        return $this->type;
    }

    /**
     * Set legend series names (ECharts `legend.data`).
     *
     * @param  list<string>  $labels
     * @return $this
     */
    public function labels(array $labels): static
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * @return list<string>|null
     */
    public function getLabels(): ?array
    {
        return $this->labels;
    }

    /**
     * Get the representation of the legend.
     *
     * @return array<string,mixed>
     */
    protected function representation(): array
    {
        return [
            'type' => $this->getType()?->value,
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'zlevel' => $this->getZLevel(),
            'z' => $this->getZ(),
            'left' => $this->getLeft(),
            'top' => $this->getTop(),
            'right' => $this->getRight(),
            'bottom' => $this->getBottom(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'padding' => $this->getPadding(),
            'data' => $this->getLabels(),
            'inactiveColor' => $this->getInactiveColor(),
            'inactiveBorderColor' => $this->getInactiveBorderColor(),
            'inactiveBorderWidth' => $this->getInactiveWidth(),
        ];
    }
}
