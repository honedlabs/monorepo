<?php

namespace Conquest\Core;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
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
    use EvaluatesClosures;
    use Conditionable;
    use Macroable;
    use Tappable;

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
