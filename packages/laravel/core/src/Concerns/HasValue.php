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
     */
    public function value(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of the instance.
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Get the normalized value of the instance.
     */
    public function getNormalizedValue(): mixed
    {
        return $this->normalizeValue($this->getValue());
    }

    /**
     * Normalize the value of the instance.
     */
    public function normalizeValue(mixed $value): mixed
    {
        return match (true) {
            $value instanceof Arrayable => $value->toArray(),
            $value instanceof CarbonInterface => $value->format('Y-m-d\TH:i:s'),
            default => $value,
        };
    }
}
