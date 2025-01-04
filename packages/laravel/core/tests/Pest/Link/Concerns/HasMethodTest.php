<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Link\Concerns\HasMethod;
use Symfony\Component\HttpFoundation\Request;

class HasMethodTest
{
    use Evaluable;
    use HasMethod;
}

beforeEach(function () {
    $this->test = new HasMethodTest;
});

it('is `get` by default', function () {
    expect($this->test)
        ->getMethod()->toBe(Request::METHOD_GET);
});

it('sets method', function () {
    $this->test->setMethod('get');
    expect($this->test)
        ->getMethod()->toBe(Request::METHOD_GET);
});

it('rejects null values', function () {
    $this->test->setMethod(Request::METHOD_POST);
    $this->test->setMethod(null);
    expect($this->test)
        ->getMethod()->toBe(Request::METHOD_POST);
});

it('chains method', function () {
    expect($this->test->method(Request::METHOD_POST))->toBeInstanceOf(HasMethodTest::class)
        ->getMethod()->toBe(Request::METHOD_POST);
});

it('has shorthand `asPost`', function () {
    expect($this->test->asPost())->toBeInstanceOf(HasMethodTest::class)
        ->getMethod()->toBe(Request::METHOD_POST);
});

it('has shorthand `asGet`', function () {
    expect($this->test->asGet())->toBeInstanceOf(HasMethodTest::class)
        ->getMethod()->toBe(Request::METHOD_GET);
});

it('has shorthand `asPut`', function () {
    expect($this->test->asPut())->toBeInstanceOf(HasMethodTest::class)
        ->getMethod()->toBe(Request::METHOD_PUT);
});

it('has shorthand `asPatch`', function () {
    expect($this->test->asPatch())->toBeInstanceOf(HasMethodTest::class)
        ->getMethod()->toBe(Request::METHOD_PATCH);
});

it('has shorthand `asDelete`', function () {
    expect($this->test->asDelete())->toBeInstanceOf(HasMethodTest::class)
        ->getMethod()->toBe(Request::METHOD_DELETE);
});

it('errors if invalid method is provided', function () {
    $this->test->method('invalid');
})->throws(\InvalidArgumentException::class);
