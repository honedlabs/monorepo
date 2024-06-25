<?php

namespace Vanguard\Core;

use JsonSerializable;
use Illuminate\Support\Traits\Tappable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Conditionable;
use Vanguard\Core\Concerns\EvaluatesClosures;

abstract class Primitive implements JsonSerializable
{
    use EvaluatesClosures;
    use Conditionable;
    use Macroable;
    use Tappable;
}
