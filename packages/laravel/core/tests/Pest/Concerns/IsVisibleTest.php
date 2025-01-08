<?php

declare(strict_types=1);

use Honed\Core\Concerns\IsVisible;

class IsVisibleTest
{
    use IsVisible;
}

beforeEach(function () {
    $this->test = new IsVisibleTest;
});

it('is true by default', function () {
    expect($this->test)
        ->isVisible()->toBeTrue();
});

it('sets visible', function () {
    expect($this->test->visible())
        ->toBeInstanceOf(IsVisibleTest::class)
        ->isVisible()->toBeTrue();
});

it('sets invisible', function () {
    expect($this->test->invisible())
        ->toBeInstanceOf(IsVisibleTest::class)
        ->isVisible()->toBeFalse();
});
