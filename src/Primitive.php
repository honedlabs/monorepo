<?php

namespace Conquest\Core;

use Conquest\Core\Concerns\Configurable;
use Conquest\Core\Concerns\EvaluatesClosures;
use Conquest\Core\Contracts\Makeable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use JsonSerializable;

/**
 * Describe and create primitive objects.
 *
 * @method make
 * @method toArray
 */
abstract class Primitive implements Arrayable, JsonSerializable, Makeable
{
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
