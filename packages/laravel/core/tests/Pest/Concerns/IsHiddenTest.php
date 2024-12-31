<?php

use Honed\Core\Concerns\IsHidden;

class IsHiddenComponent
{
    use IsHidden;
}

beforeEach(function () {
    $this->component = new IsHiddenComponent;
});

it('is not `hidden` by default', function () {
    expect($this->component->isHidden())->toBeFalse();
});

it('sets hidden', function () {
    $this->component->setHidden(true);
    expect($this->component->isHidden())->toBeTrue();
});

it('chains hidden', function () {
    expect($this->component->hidden())->toBeInstanceOf(IsHiddenComponent::class)
        ->isHidden()->toBeTrue();
});

it('has alias `hide` for `hidden`', function () {
    expect($this->component->hide())->toBeInstanceOf(IsHiddenComponent::class)
        ->isHidden()->toBeTrue();
});

it('has alias `show` for `hidden`', function () {
    expect($this->component->show())->toBeInstanceOf(IsHiddenComponent::class)
        ->isHidden()->toBeFalse();
});
