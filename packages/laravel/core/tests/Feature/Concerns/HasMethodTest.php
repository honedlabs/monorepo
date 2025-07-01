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
        ->getMethod()->toBe('get')
        ->method(Request::METHOD_POST)->toBe($this->test)
        ->getMethod()->toBe('post')
        ->patch()->toBe($this->test)
        ->getMethod()->toBe('patch')
        ->put()->toBe($this->test)
        ->getMethod()->toBe('put')
        ->delete()->toBe($this->test)
        ->getMethod()->toBe('delete')
        ->post()->toBe($this->test)
        ->getMethod()->toBe('post')
        ->get()->toBe($this->test)
        ->getMethod()->toBe('get');
});

it('validates method', function ($input) {
    $this->test->method($input);
})->throws(InvalidArgumentException::class)->with([
    [null],
    ['INVALID'],
]);
