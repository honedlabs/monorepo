<?php

declare(strict_types=1);

use Honed\Core\Concerns\IsVisible;

class VisibleTest
{
    use IsVisible;
}

beforeEach(function () {
    $this->test = new VisibleTest;
});

it('is true by default', function () {
    expect($this->test)
        ->isVisible()->toBeTrue();
});

it('sets visible', function () {
    expect($this->test->visible())
        ->toBeInstanceOf(VisibleTest::class)
        ->isVisible()->toBeTrue();
});

it('sets invisible', function () {
    expect($this->test->invisible())
        ->toBeInstanceOf(VisibleTest::class)
        ->isVisible()->toBeFalse();
});
