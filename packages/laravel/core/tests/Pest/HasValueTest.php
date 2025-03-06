<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasValue;

class ValueTest
{
    use HasValue;
}

beforeEach(function () {
    $this->test = new ValueTest;
});

it('is null by default', function () {
    expect($this->test)
        ->hasValue()->toBeFalse();
});

it('sets', function () {
    expect($this->test->value('test'))
        ->toBeInstanceOf(ValueTest::class)
        ->hasValue()->toBeTrue();
});

it('gets', function () {
    expect($this->test->value('test'))
        ->getValue()->toBe('test')
        ->hasValue()->toBeTrue();
});
