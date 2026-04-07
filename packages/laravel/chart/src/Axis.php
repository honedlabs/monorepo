<?php

declare(strict_types=1);

namespace Honed\Chart;

use DateTimeImmutable;
use Honed\Chart\Concerns\Axis\HasAxisType;
use Honed\Chart\Concerns\Axis\HasBoundaryGap;
use Honed\Chart\Concerns\Axis\HasDimension;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\Components\HasTooltip;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\InteractsWithData;
use Honed\Chart\Concerns\Proxies\Proxyable;
use Honed\Chart\Concerns\Support\Inferrable;
use Honed\Chart\Contracts\Resolvable;
use Honed\Chart\Enums\AxisType;
use Honed\Chart\Proxies\HigherOrderTooltip;
use Illuminate\Support\Traits\ForwardsCalls;

class Axis extends Chartable implements Resolvable
{
    use CanBeShown;
    use ForwardsCalls;
    use HasAxisType;
    use HasBoundaryGap;
    use HasDimension;
    use HasId;
    use HasTooltip;
    use HasTooltip;
    use Inferrable;
    use InteractsWithData;
    use Proxyable;

    /**
     * Indicate whether the data should be generated for the axis.
     *
     * @var bool
     */
    protected $generate = true;

    /**
     * Get a property of the axis.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'tooltip' => new HigherOrderTooltip($this, $this->withTooltip()),
            default => $this->defaultGet($name),
        };
    }

    /**
     * Set whether the data should be generated for the axis.
     *
     * @internal
     *
     * @return $this
     */
    public function generate(bool $value = true): static
    {
        $this->generate = $value;

        return $this;
    }

    /**
     * Determine whether the data should be generated for the axis.
     *
     * @internal
     */
    public function shouldGenerate(): bool
    {
        return $this->generate;
    }

    /**
     * Resolve the axis with the given data.
     *
     * @param  list<mixed>  $data
     */
    public function resolve(mixed $data): void
    {
        $this->define();

        if ($this->hasData()) {
            return;
        }

        $data = $this->retrieve($data, $this->getCategory());

        if (is_null($data)) {
            return;
        }

        if ($this->infers()) {
            $this->inferType($data);
        }

        if ($this->shouldGenerate()) {
            $this->data($data);
        }
    }

    /**
     * Infer the type of the axis based on the data.
     *
     * @param  list<mixed>  $data
     */
    protected function inferType(mixed $data): void
    {
        match (true) {
            $this->hasType() => null,
            empty($data) => $this->type(AxisType::Value),
            is_numeric($data[0]) => $this->type(AxisType::Value),
            is_string($data[0]) => $this->type(AxisType::Category),
            $data[0] instanceof DateTimeImmutable => $this->type(AxisType::Time),
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
            'boundaryGap' => $this->getBoundaryGap(),
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
