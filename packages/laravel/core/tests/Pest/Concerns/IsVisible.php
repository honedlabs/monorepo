<?php

use Honed\Core\Concerns\IsVisible;

class IsVisibleComponent
{
    use IsVisible;
}

beforeEach(function () {
    $this->component = new IsVisibleComponent;
});

it('is `visible` by default', function () {
    expect($this->component->isVisible())->toBeTrue();
});

it('sets visible', function () {
    $this->component->setVisible(true);
    expect($this->component->isVisible())->toBeTrue();
});

it('chains visible', function () {
    expect($this->component->visible(true))->toBeInstanceOf(IsVisibleComponent::class)
        ->isVisible()->toBeTrue();
});

it('has alias `invisible` for `visible`', function () {
    expect($this->component->invisible(true))->toBeInstanceOf(IsVisibleComponent::class)
        ->isVisible()->toBeFalse();
});
