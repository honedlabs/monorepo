<?php

use Honed\Core\Concerns\IsActive;

class IsActiveComponent
{
    use IsActive;
}

beforeEach(function () {
    $this->component = new IsActiveComponent;
});

it('is not active by default', function () {
    expect($this->component->isActive())->toBeFalse();
});

it('sets active', function () {
    $this->component->setActive(true);
    expect($this->component->isActive())->toBeTrue();
});

it('chains active', function () {
    expect($this->component->active(true))->toBeInstanceOf(IsActiveComponent::class)
        ->isActive()->toBeTrue();
});
