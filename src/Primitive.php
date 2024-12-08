<?php

declare(strict_types=1);

namespace Honed\Core;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

/**
 * @implements Arrayable<string, mixed>
 */
abstract class Primitive implements \JsonSerializable, Arrayable, Contracts\Makeable
{
    use Concerns\Assignable;
    use Concerns\Configurable;
    use Concerns\Evaluable;
    use Conditionable;
    use Macroable;
    use Tappable;

    public function __construct()
    {
        $this->configure();
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
