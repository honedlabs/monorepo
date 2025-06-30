<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasMethod;
use Symfony\Component\HttpFoundation\Request;

beforeEach(function () {
    $this->test = new class()
    {
        use HasMethod;
    };
});

it('sets method', function () {
    expect($this->test)
        ->getMethod()->toBe(Request::METHOD_GET)
        ->method(Request::METHOD_POST)->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_POST)
        ->patch()->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_PATCH)
        ->put()->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_PUT)
        ->delete()->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_DELETE)
        ->post()->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_POST)
        ->get()->toBe($this->test)
        ->getMethod()->toBe(Request::METHOD_GET);
});

it('validates method', function ($input) {
    $this->test->method($input);
})->throws(InvalidArgumentException::class)->with([
    [null],
    ['INVALID'],
]);
