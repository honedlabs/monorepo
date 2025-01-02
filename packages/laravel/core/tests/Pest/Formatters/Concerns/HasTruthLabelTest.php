<?php

use Honed\Core\Formatters\Concerns\HasTruthLabel;

class HasTruthLabelComponent
{
    use HasTruthLabel;
}

beforeEach(function () {
    $this->component = new HasTruthLabelComponent;
    HasTruthLabelComponent::useTruthLabel();
});

it('has a default truth label', function () {
    expect($this->component)
        ->getTruthLabel()->toBe(HasTruthLabelComponent::TruthLabel);
});

it('sets truth label', function () {
    $this->component->setTruthLabel('TruthLabel');
    expect($this->component)
        ->getTruthLabel()->toBe('TruthLabel');
});

it('rejects null values', function () {
    $this->component->setTruthLabel('TruthLabel');
    $this->component->setTruthLabel(null);
    expect($this->component)
        ->getTruthLabel()->toBe('TruthLabel');
});

it('chains truth label', function () {
    expect($this->component->truthLabel('TruthLabel'))->toBeInstanceOf(HasTruthLabelComponent::class)
        ->getTruthLabel()->toBe('TruthLabel');
});

it('has configurable default truth label', function () {
    HasTruthLabelComponent::useTruthLabel('TruthLabel');
    expect(HasTruthLabelComponent::getDefaultTruthLabel())->toBe('TruthLabel');
    expect($this->component)->getTruthLabel()->toBe('TruthLabel');
});

it('has alias `ifTrue` for `truthLabel`', function () {
    expect($this->component->ifTrue('TruthLabel'))->toBeInstanceOf(HasTruthLabelComponent::class)
        ->getTruthLabel()->toBe('TruthLabel');
});