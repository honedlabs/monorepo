<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasValue;

class HasValueComponent
{
    use HasValue;
}

beforeEach(function () {
    $this->component = new HasValueComponent;
});

it('has no value by default', function () {
    expect($this->component)
        ->getValue()->toBeNull();
});

it('sets value', function () {
    $this->component->setValue('Value');
    expect($this->component)
        ->getValue()->toBe('Value');
});

it('chains value', function () {
    expect($this->component->value('Value'))->toBeInstanceOf(HasValueComponent::class)
        ->getValue()->toBe('Value');
});
