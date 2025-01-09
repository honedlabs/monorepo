<?php

declare(strict_types=1);

use Honed\Core\Concerns\IsStrict;

class StrictTest
{
    use IsStrict;
}

beforeEach(function () {
    $this->test = new StrictTest;
});

it('is false by default', function () {
    expect($this->test)
        ->isStrict()->toBeFalse();
});

it('sets strict', function () {
    expect($this->test->strict())
        ->toBeInstanceOf(StrictTest::class)
        ->isStrict()->toBeTrue();
});

it('sets relaxed', function () {
    expect($this->test->relaxed())
        ->toBeInstanceOf(StrictTest::class)
        ->isStrict()->toBeFalse();
});
