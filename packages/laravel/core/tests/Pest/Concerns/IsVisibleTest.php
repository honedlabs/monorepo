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

it('is `visible` by default', function () {
    expect($this->test->isVisible())->toBeTrue();
});

it('sets visible', function () {
    $this->test->setVisible(true);
    expect($this->test->isVisible())->toBeTrue();
});

it('chains visible', function () {
    expect($this->test->visible(true))->toBeInstanceOf(IsVisibleTest::class)
        ->isVisible()->toBeTrue();
});

it('has alias `invisible` for `visible`', function () {
    expect($this->test->invisible(true))->toBeInstanceOf(IsVisibleTest::class)
        ->isVisible()->toBeFalse();
});
