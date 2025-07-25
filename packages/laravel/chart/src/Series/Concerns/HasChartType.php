<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Concerns;

use Honed\Chart\Enums\ChartType;

trait HasChartType
{
    /**
     * The type of the series.
     * 
     * @var \Honed\Chart\Enums\ChartType
     */
    protected $type;

    /**
     * Set the type of the series.
     * 
     * @param \Honed\Chart\Enums\ChartType|string $type
     * @return $this
     * 
     * @throws \ValueError if the type is not a valid chart type
     */
    public function type(ChartType|string $type): static
    {
        if (! $type instanceof ChartType) {
            $type = ChartType::from($type);
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get the type of the series.
     */
    public function getType(): ?string
    {
        return $this->type?->value;
    }
}