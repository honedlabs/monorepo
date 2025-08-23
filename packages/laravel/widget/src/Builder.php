<?php

declare(strict_types=1);

namespace Honed\Widget;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Builder extends EloquentBuilder
{

}