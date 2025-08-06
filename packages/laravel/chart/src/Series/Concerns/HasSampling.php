<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Concerns;

use Honed\Chart\Enums\Sampling;

/**
 * @internal
 */
trait HasSampling
{
    /**
     * The downsampling strategy.
     * 
     * @var string|null
     */
    protected $sampling;

    /**
     * Set the downsampling strategy.
     * 
     * @return $this
     */
    public function sampling(string|Sampling $value): static
    {
        $this->sampling = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the downsampling strategy to be lttb.
     * 
     * @return $this
     */
    public function samplingLttb(): static
    {
        return $this->sampling(Sampling::Lttb);
    }

    /**
     * Set the downsampling strategy to be average.
     * 
     * @return $this
     */
    public function samplingAverage(): static
    {
        return $this->sampling(Sampling::Average);
    }

    /**
     * Set the downsampling strategy to be max.
     * 
     * @return $this
     */
    public function samplingMax(): static
    {
        return $this->sampling(Sampling::Max);
    }

    /**
     * Set the downsampling strategy to be min.
     * 
     * @return $this
     */
    public function samplingMin(): static
    {
        return $this->sampling(Sampling::Min);
    }

    /**
     * Set the downsampling strategy to be minmax.
     * 
     * @return $this
     */
    public function samplingMinMax(): static
    {
        return $this->sampling(Sampling::MinMax);
    }

    /**
     * Set the downsampling strategy to be sum.
     * 
     * @return $this
     */
    public function samplingSum(): static
    {
        return $this->sampling(Sampling::Sum);
    }

    /**
     * Get the downsampling strategy.
     */
    public function getSampling(): ?string
    {
        return $this->sampling;
    }
}