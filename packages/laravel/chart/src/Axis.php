<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Chartable;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\Components\HasTooltip;
use Honed\Chart\Concerns\InteractsWithData;
use Honed\Chart\Contracts\Resolvable;
use Honed\Chart\Enums\AxisType;
use Honed\Chart\Enums\Dimension;
use Illuminate\Support\Traits\ForwardsCalls;

class Axis extends Chartable implements Resolvable
{
    use ForwardsCalls;
    use CanBeShown;
    use HasId;
    use HasTooltip;
    use InteractsWithData;

    /**
     * The type of the axis.
     * 
     * @var ?\Honed\Chart\Enums\AxisType
     */
    protected $type;

    /**
     * Set the dimension of the axis.
     * 
     * @var ?\Honed\Chart\Enums\Dimension
     */
    protected $dimension;

    /**
     * Set the type of the axis.
     *
     * @return $this
     */
    public function type(AxisType|string $value): static
    {
        $this->type = is_string($value) ? AxisType::from($value) : $value;

        return $this;
    }
    
    /**
     * Set the type of the axis to be value.
     *
     * @return $this
     */
    public function value(): static
    {
        return $this->type(AxisType::Value);
    }

    /**
     * Set the type of the axis to be category.
     *
     * @return $this
     */
    public function category(): static
    {
        return $this->type(AxisType::Category);
    }

    /**
     * Set the type of the axis to be time.
     *
     * @return $this
     */
    public function time(): static
    {
        return $this->type(AxisType::Time);
    }

    /**
     * Set the type of the axis to be log.
     *
     * @return $this
     */
    public function log(): static
    {
        return $this->type(AxisType::Log);
    }

    /**
     * Get the type of the axis.
     */
    public function getType(): ?AxisType
    {
        return $this->type;
    }

    /**
     * Set the dimension of the axis.
     *
     * @return $this
     */
    public function dimension(Dimension|string $value): static
    {
        $this->dimension = is_string($value) ? Dimension::from($value) : $value;

        return $this;
    }

    /**
     * Set the dimension of the axis to be x.
     *
     * @return $this
     */
    public function x(): static
    {
        return $this->dimension(Dimension::X);
    }

    /**
     * Set the dimension of the axis to be y.
     *
     * @return $this
     */
    public function y(): static
    {
        return $this->dimension(Dimension::Y);
    }

    /**
     * Get the dimension of the axis.
     */
    public function getDimension(): ?Dimension
    {
        return $this->dimension;
    }

    /**
     * Resolve the axis with the given data.
     */
    public function resolve(mixed $data): void
    {
        $this->define();

        if ($this->hasData()) {
            return;
        }

        $data = $this->retrieve($data, $this->getValue());

        $this->data($data);
    }

    /**
     * Get the representation of the axis.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        $this->define();

        return [
            'id' => $this->getId(),
            'show' => $this->isShown(),
            // 'gridIndex' => $this->getGridIndex(),
            // 'alignTicks' => $this->hasAlignedTicks(),
            // 'position' => $this->getPosition(),
            // 'offset' => $this->getOffset(),
            'type' => $this->getType(),
            // 'name' => null,
            // 'nameLocation' => null,
            // 'nameTextStyle' => null,
            // 'nameGap' => $this->getNameGap(),
            // 'nameRotate' => $this->getNameRotate(),
            // 'nameTruncate' => $this->getTruncate()?->toArray(),
            // 'inverse' => $this->isInverted(),
            // 'boundaryGap' => $this->getBoundaryGap(),
            // 'min' => $this->getMin(),
            // 'max' => $this->getMax(),
            // 'scale' => $this->isScaled() ?: null,
            // 'splitNumber' => $this->getSplitNumber(),
            // 'minInterval' => $this->getMinInterval(),
            // 'maxInterval' => $this->getMaxInterval(),
            // 'interval' => $this->getInterval(),
            // 'logBase' => $this->getLogBase(),
            // 'startValue' => $this->getStartValue(),
            // 'silent' => $this->isSilent() ?: null,
            // 'triggerEvent' => $this->isTriggerable(),
            // 'axisLine',
            // 'axisTick',
            // 'minorTick',
            // 'axisLabel'
            // 'splitLine'
            // 'minorSplitLine'
            // 'splitArea'
            'data' => $this->getData(),
            // 'axisPointer' => $this->getAxisPointer()?->toArray(),
            'tooltip' => $this->getTooltip()?->toArray(),
        ];
    }
}
