<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Chart;
use Honed\Chart\Chartable;
use Honed\Chart\Concerns\Components\HasEmphasis;
use Honed\Chart\Concerns\Components\HasTooltip;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\InteractsWithData;
use Honed\Chart\Concerns\Proxies\Proxyable;
use Honed\Chart\Concerns\Style\HasCursor;
use Honed\Chart\Concerns\Support\Inferrable;
use Honed\Chart\Contracts\Resolvable;
use Honed\Chart\Enums\ChartType;
use Honed\Chart\Proxies\HigherOrderEmphasis;
use Honed\Chart\Proxies\HigherOrderTooltip;
use Honed\Core\Concerns\HasName;
use Illuminate\Support\Traits\ForwardsCalls;
use TypeError;
use ValueError;

/**
 * @property-read \Honed\Chart\Proxies\HigherOrderEmphasis<static> $emphasis
 * @property-read \Honed\Chart\Proxies\HigherOrderTooltip<static> $tooltip
 */
abstract class Series extends Chartable implements Resolvable
{
    use ForwardsCalls;
    use HasCursor;
    use HasEmphasis;
    use HasId;
    use HasName;
    use HasTooltip;
    use Inferrable;
    use InteractsWithData;
    use Proxyable;

    /**
     * The type of the series.
     *
     * @var ChartType
     */
    public $type;

    /**
     * Get a property of the series.
     * 
     * @param  non-empty-string  $name
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'emphasis' => new HigherOrderEmphasis($this, $this->withEmphasis()),
            'tooltip' => new HigherOrderTooltip($this, $this->withTooltip()),
            default => $this->defaultGet($name),
        };
    }

    /**
     * Determine if the series requires axes to be provided.
     */
    public function requiresAxes(): bool
    {
        return true;
    }

    /**
     * Set the type of the series.
     *
     * @return $this
     *
     * @throws ValueError
     * @throws TypeError
     */
    public function type(string|ChartType $value): static
    {
        $this->type = is_string($value) ? ChartType::from($value) : $value;

        return $this;
    }

    /**
     * Get the type of the series.
     */
    public function getType(): ChartType
    {
        return $this->type;
    }

    /**
     * Convert the series directly to a chart.
     */
    public function toChart(): Chart
    {
        return Chart::make()
            ->source($this->getSource())
            ->category($this->getCategory())
            ->value($this->getValue())
            ->infer($this->infers())
            ->series($this);
    }

    /**
     * Resolve the series with the given data.
     *
     * @param  list<mixed>  $data
     */
    public function resolve(mixed $data): void
    {
        $this->define();

        if ($this->hasData()) {
            return;
        }

        $data = $this->retrieve($data, $this->getValue());

        if (is_null($data)) {
            return;
        }

        $this->data($data);
    }

    /**
     * Get the representation of the series.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        $this->define();

        return [
            'type' => $this->getType()->value,
            'id' => $this->getId(),
            'name' => isset($this->name) ? $this->getName() : null, // @phpstan-ignore-line
            'data' => $this->getData(),
            'cursor' => $this->getCursor(),
            'emphasis' => $this->getEmphasis()?->toArray(),
            // 'clip' => $this->isClipped() ? null : false,
            // ...$this->getZAxisParameters(),
        ];
    }
}
