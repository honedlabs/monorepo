<?php

declare(strict_types=1);

namespace Honed\Core;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

abstract class Primitive implements Arrayable, \JsonSerializable, Contracts\Makeable
{
    use Conditionable;
    use Macroable;
    use Tappable;
    use Concerns\Assignable;
    use Concerns\Configurable;
    use Concerns\Evaluable;

    public function __construct()
    {
        $this->configure();
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
