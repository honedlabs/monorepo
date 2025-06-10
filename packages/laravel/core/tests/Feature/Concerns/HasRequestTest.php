<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasRequest;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->test = new class()
    {
        use HasRequest;
    };
});

it('sets', function () {
    expect($this->test)
        ->request(new Request())->toBe($this->test)
        ->getRequest()->toBeInstanceOf(Request::class);
});
