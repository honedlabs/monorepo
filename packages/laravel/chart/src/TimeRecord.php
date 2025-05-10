<?php

declare(strict_types=1);

namespace Honed\Chart;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @implements \Illuminate\Contracts\Support\Arrayable<string, mixed>
 */
class TimeRecord implements Arrayable, JsonSerializable
{
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [];
    }
}