<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasDescription;

class HasDescriptionComponent
{
    use Evaluable;
    use HasDescription;
}

beforeEach(function () {
    $this->component = new HasDescriptionComponent;
});

it('has no description by default', function () {
    expect($this->component)
        ->getDescription()->toBeNull()
        ->hasDescription()->toBeFalse();
});

it('sets description', function () {
    $this->component->setDescription('Description');
    expect($this->component)
        ->getDescription()->toBe('Description')
        ->hasDescription()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setDescription('Description');
    $this->component->setDescription(null);
    expect($this->component)
        ->getDescription()->toBe('Description')
        ->hasDescription()->toBeTrue();
});

it('chains description', function () {
    expect($this->component->description('Description'))->toBeInstanceOf(HasDescriptionComponent::class)
        ->getDescription()->toBe('Description')
        ->hasDescription()->toBeTrue();
});

it('resolves description', function () {
    expect($this->component->description(fn ($record) => $record.'.'))
        ->toBeInstanceOf(HasDescriptionComponent::class)
        ->resolveDescription(['record' => 'Description'])->toBe('Description.')
        ->getDescription()->toBe('Description.');
});
