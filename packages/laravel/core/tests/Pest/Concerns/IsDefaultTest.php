<?php

use Honed\Core\Concerns\IsDefault;

class IsDefaultComponent
{
    use IsDefault;
}

beforeEach(function () {
    $this->component = new IsDefaultComponent;
});

it('is not `default` by default', function () {
    expect($this->component->isDefault())->toBeFalse();
});

it('sets default', function () {
    $this->component->setDefault(true);
    expect($this->component->isDefault())->toBeTrue();
});

it('chains default', function () {
    expect($this->component->default(true))->toBeInstanceOf(IsDefaultComponent::class)
        ->isDefault()->toBeTrue();
});
