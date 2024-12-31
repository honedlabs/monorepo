<?php

use Honed\Core\Concerns\Validatable;
use Honed\Core\Tests\Stubs\Component;

class ValidatableComponent
{
    use Validatable;
}

beforeEach(function () {
    $this->component = new ValidatableComponent;
    $this->fn = fn (int $record) => $record > 0;
});

it('has no validator by default', function () {
    expect($this->component)
        ->getValidator()->toBeNull()
        ->canValidate()->toBeFalse()
        ->applyValidation('Anything')->toBeTrue();
});

it('sets validator', function () {
    $this->component->setValidate($this->fn);
    expect($this->component)
        ->getValidator()->toBeInstanceOf(\Closure::class)
        ->canValidate()->toBeTrue()
        ->applyValidation(1)->toBeTrue()
        ->applyValidation(0)->toBeFalse();
});

it('rejects null values', function () {
    $this->component->setValidate($this->fn);
    $this->component->setValidate(null);

    expect($this->component)
        ->getValidator()->toBeInstanceOf(\Closure::class)
        ->canValidate()->toBeTrue()
        ->applyValidation(1)->toBeTrue()
        ->applyValidation(0)->toBeFalse();
});

it('chains validator', function () {
    expect($this->component->validate($this->fn))->toBeInstanceOf(ValidatableComponent::class)
        ->getValidator()->toBeInstanceOf(\Closure::class)
        ->canValidate()->toBeTrue()
        ->applyValidation(1)->toBeTrue()
        ->applyValidation(0)->toBeFalse();
});

it('validates values', function () {
    $this->component->setValidate($this->fn);
    expect($this->component)
        ->applyValidation(1)->toBeTrue()
        ->applyValidation(0)->toBeFalse();
});

it('has alias `isValid` for `applyValidation`', function () {
    $this->component->setValidate($this->fn);
    expect($this->component)
        ->isValid(1)->toBeTrue()
        ->isValid(0)->toBeFalse();
});
