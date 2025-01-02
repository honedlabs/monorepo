<?php

use Honed\Core\Formatters\Concerns\HasFalseLabel;

class HasFalseLabelComponent
{
    use HasFalseLabel;
}

beforeEach(function () {
    $this->component = new HasFalseLabelComponent;
    HasFalseLabelComponent::useFalseLabel();
});

it('has a default false label', function () {
    expect($this->component)
        ->getFalseLabel()->toBe(HasFalseLabelComponent::FalseLabel);
});

it('sets false label', function () {
    $this->component->setFalseLabel('FalseLabel');
    expect($this->component)
        ->getFalseLabel()->toBe('FalseLabel');
});

it('rejects null values', function () {
    $this->component->setFalseLabel('FalseLabel');
    $this->component->setFalseLabel(null);
    expect($this->component)
        ->getFalseLabel()->toBe('FalseLabel');
});

it('chains false label', function () {
    expect($this->component->falseLabel('FalseLabel'))->toBeInstanceOf(HasFalseLabelComponent::class)
        ->getFalseLabel()->toBe('FalseLabel');
});

it('has configurable default false label', function () {
    HasFalseLabelComponent::useFalseLabel('FalseLabel');
    expect(HasFalseLabelComponent::getDefaultFalseLabel())->toBe('FalseLabel');
    expect($this->component)->getFalseLabel()->toBe('FalseLabel');
});

it('has alias `ifFalse` for `falseLabel`', function () {
    expect($this->component->ifFalse('FalseLabel'))->toBeInstanceOf(HasFalseLabelComponent::class)
        ->getFalseLabel()->toBe('FalseLabel');
});
