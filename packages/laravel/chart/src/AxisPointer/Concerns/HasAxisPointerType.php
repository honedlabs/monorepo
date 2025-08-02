<?php

declare(strict_types=1);

namespace Honed\Chart\AxisPointer\Concerns;

use Honed\Chart\Enums\AxisPointerType;

trait HasAxisPointerType
{
    /**
     * The indicator type.
     * 
     * @var string|null
     */
    protected $type;

    /**
     * Set the indicator type.
     * 
     * @return $this
     */
    public function type(string|AxisPointerType $value): static
    {
        $this->type = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Get the indicator type.
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}