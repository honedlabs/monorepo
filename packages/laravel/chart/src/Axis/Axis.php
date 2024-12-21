<?php

namespace Conquest\Chart\Axis;

use Conquest\Chart\Axis\Concerns\HasAxisType;
use Conquest\Chart\Axis\Enums\AxisType;

class Axis
{
    use HasAxisType;

    public function __construct(
        AxisType|string|null $type = null
    ) {
        $this->setType($type);

    }

    public static function make(
        AxisType|string|null $type = null
    ): static {
        return resolve(static::class, compact('type'));
    }
}
