<?php

declare(strict_types=1);

use Honed\Action\Concerns\HasEndpoint;

beforeEach(function () {
    $this->test = new class {
        use HasEndpoint;
    };
});

it('has endpoint', function () {
    expect($this->test)
        ->hasEndpoint()->toBeFalse()
        ->getEndpoint()->toBe(config('action.endpoint'))
        ->endpoint('/example')->toBe($this->test)
        ->hasEndpoint()->toBeTrue()
        ->getEndpoint()->toBe('/example')
        ->getDefaultEndpoint()->toBe(config('action.endpoint'));
});
