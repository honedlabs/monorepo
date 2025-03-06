<?php

declare(strict_types=1);

use Honed\Core\Concerns\IsActive;

class ActiveTest
{
    use IsActive;
}

beforeEach(function () {
    $this->test = new ActiveTest;
});

it('is false by default', function () {
    expect($this->test)
        ->isActive()->toBeFalse();
});

it('sets active', function () {
    expect($this->test->active())
        ->toBeInstanceOf(ActiveTest::class)
        ->isActive()->toBeTrue();
});

it('sets inactive', function () {
    expect($this->test->inactive())
        ->toBeInstanceOf(ActiveTest::class)
        ->isActive()->toBeFalse();
});
