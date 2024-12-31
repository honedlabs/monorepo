<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasLabel;

class HasLabelComponent
{
    use HasLabel;
    use Evaluable;
}

beforeEach(function () {
    $this->component = new HasLabelComponent;
});

it('has no label by default', function () {
    expect($this->component)
        ->getLabel()->toBeNull()
        ->hasLabel()->toBeFalse();
});

it('sets label', function () {
    $this->component->setLabel('Label');
    expect($this->component)
        ->getLabel()->toBe('Label')
        ->hasLabel()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setLabel('Label');
    $this->component->setLabel(null);
    expect($this->component)
        ->getLabel()->toBe('Label')
        ->hasLabel()->toBeTrue();
});

it('chains label', function () {
    expect($this->component->label('Label'))->toBeInstanceOf(HasLabelComponent::class)
        ->getLabel()->toBe('Label')
        ->hasLabel()->toBeTrue();
});

it('resolves label', function () {
    expect($this->component->label(fn ($record) => $record.'.'))
        ->toBeInstanceOf(HasLabelComponent::class)
        ->resolveLabel(['record' => 'Label'])->toBe('Label.')
        ->getLabel()->toBe('Label.');
});

it('makes a label', function () {
    expect($this->component->makeLabel('new-Label'))->toBe('New label');
});
