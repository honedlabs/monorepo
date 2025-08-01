<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\GradientType;

trait HasGradientType
{
    /**
     * The gradient type.
     * 
     * @var string
     */
    protected $type = 'linear';

    /**
     * Set the gradient type.
     * 
     * @return $this
     */
    public function type(string|GradientType $value): static
    {
        $this->type = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the gradient type to be linear.
     * 
     * @return $this
     */
    public function linear(): static
    {
        return $this->type(GradientType::Linear);
    }

    /**
     * Set the gradient type to be radial.
     * 
     * @return $this
     */
    public function radial(): static
    {
        return $this->type(GradientType::Radial);
    }

    /**
     * Get the gradient type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Check if the gradient is linear.
     */
    public function isLinear(): bool
    {
        return $this->getType() === GradientType::Linear->value;
    }

    /**
     * Check if the gradient is radial.
     */
    public function isRadial(): bool
    {
        return $this->getType() === GradientType::Radial->value;
    }
}