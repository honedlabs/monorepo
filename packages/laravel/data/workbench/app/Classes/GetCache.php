<?php

declare(strict_types=1);

namespace App\Classes;

use Honed\Data\Attributes\Contextual\CacheParameter;

class GetCache
{
    public function __construct(
        #[CacheParameter('test')]
        public mixed $test
    ) {}

    public function get(): mixed
    {
        return $this->test;
    }
}