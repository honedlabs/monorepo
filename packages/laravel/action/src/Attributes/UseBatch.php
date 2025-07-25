<?php

declare(strict_types=1);

namespace Honed\Action\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class UseBatch
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string<\Honed\Action\Batch>  $batchClass
     * @return void
     */
    public function __construct(
        public string $batchClass
    ) {}
}
