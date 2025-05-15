<?php

declare(strict_types=1);

namespace Honed\Chart;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Macroable;
use JsonSerializable;

/**
 * @extends \Illuminate\Contracts\Support\Arrayable<string, mixed>
 */
abstract class ChartComponent implements Arrayable, JsonSerializable
{
    use Macroable {
        __call as macroCall;
    }

    /**
     * Flush the state of the instance.
     * 
     * @return void
     */
    abstract public static function flushState();

    /**
     * Get the representation of the instance.
     * 
     * @return array<string, mixed>
     */
    abstract public function representation();

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return \array_filter(
            $this->representation(),
            static fn ($value) => ! \is_null($value)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $parameters)
    {
        $this->macroCall($method, $parameters);
    }
}