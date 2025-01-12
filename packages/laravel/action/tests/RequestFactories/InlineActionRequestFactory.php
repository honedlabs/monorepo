<?php

declare(strict_types=1);

namespace Tests\RequestFactories;

use Honed\Action\Creator;
use Worksome\RequestFactories\RequestFactory;

class InlineActionRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name' => 'update',
            'type' => Creator::Inline,
            'id' => 1
        ];
    }
}
