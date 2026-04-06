<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Chart;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Chartable;
use Honed\Chart\Concerns\Components\HasTitle;
use Honed\Chart\Concerns\Components\HasTooltip;
use Honed\Chart\Concerns\InteractsWithData;
use Honed\Chart\Contracts\Resolvable;
use Honed\Chart\Enums\ChartType;
use Honed\Chart\Style\Concerns\HasCursor;
use Honed\Core\Concerns\HasName;
use Illuminate\Support\Traits\ForwardsCalls;

use function Illuminate\Support\enum_value;

abstract class Series extends Chartable implements Resolvable
{
    use ForwardsCalls;
    use HasName;
    use HasCursor;
    use HasTooltip;
    use HasId;
    use InteractsWithData;
    
    /**
     * The type of the series.
     * 
     * @var string
     */
    public $type;

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
     */
    public function type(string|ChartType $value): static
    {
        $value = is_string($value) ? ChartType::from($value) : $value;

        $this->type = $value->value;

        return $this;
    }

    /**
     * Get the type of the series.
     */
    public function getType(): string
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
            ->series($this);
    }

    /**
     * Resolve the series with the given data.
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
     * Get the representation of the series.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        $this->define();

        return [
            'type' => $this->getType(),
            'id' => $this->getId(),
            'name' => $this->name,
            'data' => $this->getData(),
            'cursor' => $this->getCursor(),
            // 'clip' => $this->isClipped() ? null : false,
            // ...$this->getZAxisParameters(),
        ];
    }
}
