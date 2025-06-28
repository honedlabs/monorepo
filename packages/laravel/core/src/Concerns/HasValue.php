<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Arrayable;

trait HasValue
{
    /**
     * The value of the instance.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Set the value of the instance.
     *
     * @param  mixed  $value
     * @return $this
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of the instance.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the normalized value of the instance.
     *
     * @return mixed
     */
    public function getNormalizedValue()
    {
        return $this->normalizeValue($this->getValue());
    }

    /**
     * Normalize the value of the instance.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function normalizeValue($value)
    {
        return match (true) {
            $value instanceof Arrayable => $value->toArray(),
            $value instanceof CarbonInterface => $value->format('Y-m-d\TH:i:s'),
            default => $value,
        };
    }
}
