<?php

namespace Conquest\Chart\Axis\Concerns;

use Conquest\Chart\Axis\Enums\AxisType;

trait HasAxisType
{
    protected ?AxisType $type = null;

    public function type(AxisType|string $type): self
    {
        $this->setType($type);

        return $this;
    }

    public function setType(AxisType|string|null $type): void
    {
        if (is_null($type)) {
            return;
        }

        if ($type instanceof AxisType) {
            $this->type = $type;

            return;
        }

        $this->type = AxisType::tryFrom($type) ?? throw new \InvalidArgumentException("Invalid axis type provided: {$type}");

    }

    public function getType(): ?AxisType
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
