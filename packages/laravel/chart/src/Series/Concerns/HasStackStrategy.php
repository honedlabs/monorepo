<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Concerns;

use Honed\Chart\Enums\StackStrategy;

/**
 * @internal
 */
trait HasStackStrategy
{
    /**
     * The strategy to use when stacking.
     *
     * @var string|null
     */
    protected $stackStrategy;

    /**
     * Set the strategy to use when stacking.
     *
     * @return $this
     */
    public function stackStrategy(string|StackStrategy $value): static
    {
        $this->stackStrategy = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the strategy to use when stacking to be same sign, which will stack data with the same sign.
     *
     * @return $this
     */
    public function stackStrategySameSign(): static
    {
        return $this->stackStrategy(StackStrategy::SameSign);
    }

    /**
     * Set the strategy to use when stacking to be all, which will stack all data.
     *
     * @return $this
     */
    public function stackStrategyAll(): static
    {
        return $this->stackStrategy(StackStrategy::All);
    }

    /**
     * Set the strategy to use when stacking to be positive, which will stack data with positive values.
     *
     * @return $this
     */
    public function stackStrategyPositive(): static
    {
        return $this->stackStrategy(StackStrategy::Positive);
    }

    /**
     * Set the strategy to use when stacking to be negative, which will stack data with negative values.
     *
     * @return $this
     */
    public function stackStrategyNegative(): static
    {
        return $this->stackStrategy(StackStrategy::Negative);
    }

    /**
     * Get the strategy to use when stacking.
     */
    public function getStackStrategy(): ?string
    {
        return $this->stackStrategy;
    }
}
