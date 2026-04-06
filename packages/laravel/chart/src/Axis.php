<?php

declare(strict_types=1);

namespace Honed\Chart;

use Carbon\Carbon;
use DateTime;
use Honed\Chart\Chartable;
use Honed\Chart\Concerns\Axis\HasAxisType;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\Components\HasTooltip;
use Honed\Chart\Concerns\InteractsWithData;
use Honed\Chart\Concerns\Support\Inferrable;
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
    use Inferrable;
    use HasAxisType;

    /**
     * Set the dimension of the axis.
     * 
     * @var ?\Honed\Chart\Enums\Dimension
     */
    protected $dimension;

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

        $data = $this->retrieve($data, $this->getCategory());

        if ($this->infers()) {
            $this->inferType($data);
        }

        if (is_null($data)) {
            return;
        }

        $this->data($data);
    }

    /**
     * Infer the type of the axis based on the data.
     * 
     * @param list<mixed> $data
     */
    protected function inferType(mixed $data): void
    {
        match (true) {
            $this->hasType() => null,
            empty($data) => $this->type(AxisType::Value),
            is_numeric($data[0]) => $this->type(AxisType::Value),
            is_string($data[0]) => $this->type(AxisType::Category),
            $data[0] instanceof DateTime,
            $data[0] instanceof Carbon => $this->type(AxisType::Time),
            default => $this->type(AxisType::Value),
        };
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
            'type' => $this->getType()?->value,
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
