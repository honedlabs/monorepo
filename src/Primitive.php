<?php

namespace Conquest\Core;

use JsonSerializable;
use Conquest\Core\Concerns\Configurable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Tappable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Conditionable;
use Conquest\Core\Concerns\EvaluatesClosures;
use Conquest\Core\Contracts\Makeable;

/**
 * Describe and create primitive objects.
 * @method make
 * @method toArray
 */
abstract class Primitive implements JsonSerializable, Arrayable, Makeable
{
    use Configurable;
    use EvaluatesClosures;
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
