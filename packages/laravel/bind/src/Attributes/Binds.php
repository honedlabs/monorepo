<?php

declare(strict_types=1);

namespace Honed\Bind\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Binds
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $model
     * @return void
     */
    public function __construct(
        public string $model
    ) {}
}
