<?php

use Honed\Core\Formatters\Concerns\IsDifference;

class IsDifferenceComponent
{
    use IsDifference;
}

beforeEach(function () {
    $this->component = new IsDifferenceComponent;
});

it('is not `difference` by default', function () {
    expect($this->component->isDifference())->toBeFalse();
});

it('sets difference', function () {
    $this->component->setDifference(true);
    expect($this->component->isDifference())->toBeTrue();
});

it('chains difference', function () {
    expect($this->component->difference())->toBeInstanceOf(IsDifferenceComponent::class)
        ->isDifference()->toBeTrue();
});

it('has alias `since` for `difference`', function () {
    expect($this->component->since())->toBeInstanceOf(IsDifferenceComponent::class)
        ->isDifference()->toBeTrue();
});
