<?php

declare(strict_types=1);

namespace App\Classes;

use Honed\Data\Attributes\Contextual\SessionParameter;

class GetSession
{
    public function __construct(
        #[SessionParameter('test')]
        public mixed $test
    ) {}

    public function get(): mixed
    {
        return $this->test;
    }
}
