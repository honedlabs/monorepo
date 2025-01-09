<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasType;

class TypeTest
{
    use HasType;
}

beforeEach(function () {
    $this->test = new TypeTest;
});

it('is null by default', function () {
    expect($this->test)
        ->type()->toBeNull()
        ->hasType()->toBeFalse();
});

it('sets', function () {
    expect($this->test->type('test'))
        ->toBeInstanceOf(TypeTest::class)
        ->type()->toBe('test')
        ->hasType()->toBeTrue();
});

it('gets', function () {
    expect($this->test->type('test'))
        ->type()->toBe('test')
        ->hasType()->toBeTrue();
});