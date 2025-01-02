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
        ->validate('Anything')->toBeTrue();
});

it('sets validator', function () {
    $this->component->setValidator($this->fn);
    expect($this->component)
        ->getValidator()->toBeInstanceOf(\Closure::class)
        ->canValidate()->toBeTrue()
        ->validate(1)->toBeTrue()
        ->validate(0)->toBeFalse();
});

it('rejects null values', function () {
    $this->component->setValidator($this->fn);
    $this->component->setValidator(null);

    expect($this->component)
        ->getValidator()->toBeInstanceOf(\Closure::class)
        ->canValidate()->toBeTrue()
        ->validate(1)->toBeTrue()
        ->validate(0)->toBeFalse();
});

it('chains validator', function () {
    expect($this->component->validator($this->fn))->toBeInstanceOf(ValidatableComponent::class)
        ->getValidator()->toBeInstanceOf(\Closure::class)
        ->canValidate()->toBeTrue()
        ->validate(1)->toBeTrue()
        ->validate(0)->toBeFalse();
});

it('validates values', function () {
    $this->component->setValidator($this->fn);
    expect($this->component)
        ->validate(1)->toBeTrue()
        ->validate(0)->toBeFalse();
});

it('has alias `isValid` for `validate`', function () {
    $this->component->setValidator($this->fn);
    expect($this->component)
        ->isValid(1)->toBeTrue()
        ->isValid(0)->toBeFalse();
});

it('has alias `validateUsing` for `validator`', function () {
    expect($this->component->validateUsing($this->fn))->toBeInstanceOf(ValidatableComponent::class)
        ->getValidator()->toBeInstanceOf(\Closure::class)
        ->canValidate()->toBeTrue()
        ->validate(1)->toBeTrue()
        ->validate(0)->toBeFalse();
});
