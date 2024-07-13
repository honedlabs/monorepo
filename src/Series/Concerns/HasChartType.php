<?php

namespace Conquest\Chart\Series\Concerns;

use Conquest\Chart\Enums\ChartType;

trait HasChartType
{
    protected ?ChartType $type = null;

    public function type(ChartType|string $type): self
    {
        $this->setType($type);

        return $this;
    }

    public function setType(ChartType|string|null $type): void
    {
        if (is_null($type)) {
            return;
        }

        if ($type instanceof ChartType) {
            $this->type = $type;

            return;
        }

        $this->type = ChartType::tryFrom($type) ?? throw new \InvalidArgumentException("Invalid chart type provided: {$type}");
    }

    public function getType(): ?ChartType
    {
        return $this->type;
    }

    public function lacksType(): bool
    {
        return is_null($this->type);
    }

    public function hasType(): bool
    {
        return ! $this->lacksType();
    }
}
