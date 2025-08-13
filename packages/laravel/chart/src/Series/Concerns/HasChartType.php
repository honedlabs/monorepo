<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Concerns;

use Honed\Chart\Enums\ChartType;

trait HasChartType
{
    /**
     * The type of the series.
     *
     * @var string|null
     */
    protected $type;

    /**
     * Set the type of the series.
     *
     * @return $this
     */
    public function type(string|ChartType $value): static
    {
        $this->type = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Get the type of the series.
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}
