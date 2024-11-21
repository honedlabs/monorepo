<?php

declare(strict_types=1);

namespace Honed\Core;

use Honed\Core\Concerns\Assignable;
use Honed\Core\Concerns\Configurable;
use Honed\Core\Concerns\EvaluatesClosures;
use Honed\Core\Contracts\Makeable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use JsonSerializable;

abstract class Primitive implements Arrayable, JsonSerializable, Makeable
{
    use Assignable;
    use Conditionable;
    use Configurable;
    use EvaluatesClosures;
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
