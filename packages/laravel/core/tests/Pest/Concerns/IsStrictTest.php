<?php

use Honed\Core\Concerns\IsStrict;

class IsStrictComponent
{
    use IsStrict;
}

beforeEach(function () {
    $this->component = new IsStrictComponent;
});

it('is not `strict` by default', function () {
    expect($this->component->isStrict())->toBeFalse();
});

it('sets strict', function () {
    $this->component->setStrict(true);
    expect($this->component->isStrict())->toBeTrue();
});

it('chains strict', function () {
    expect($this->component->strict(true))->toBeInstanceOf(IsStrictComponent::class)
        ->isStrict()->toBeTrue();
});
