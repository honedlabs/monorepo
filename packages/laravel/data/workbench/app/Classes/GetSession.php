<?php

declare(strict_types=1);

namespace App\Classes;

use Honed\Data\Attributes\Contextual\SessionParameter;

class GetSession
{
    public function __construct(
        #[SessionParameter('test')]
        public ?string $test
    ) {}

    public function get(): ?string
    {
        return $this->test;
    }
}