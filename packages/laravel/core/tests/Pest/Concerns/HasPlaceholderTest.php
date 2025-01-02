<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasPlaceholder;

class HasPlaceholderComponent
{
    use Evaluable;
    use HasPlaceholder;
}

beforeEach(function () {
    $this->component = new HasPlaceholderComponent;
});

it('has no placeholder by default', function () {
    expect($this->component)
        ->getPlaceholder()->toBeNull()
        ->hasPlaceholder()->toBeFalse();
});

it('sets placeholder', function () {
    $this->component->setPlaceholder('Placeholder');
    expect($this->component)
        ->getPlaceholder()->toBe('Placeholder')
        ->hasPlaceholder()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setPlaceholder('Placeholder');
    $this->component->setPlaceholder(null);
    expect($this->component)
        ->getPlaceholder()->toBe('Placeholder')
        ->hasPlaceholder()->toBeTrue();
});

it('chains placeholder', function () {
    expect($this->component->placeholder('Placeholder'))->toBeInstanceOf(HasPlaceholderComponent::class)
        ->getPlaceholder()->toBe('Placeholder')
        ->hasPlaceholder()->toBeTrue();
});

it('resolves placeholder', function () {
    expect($this->component->placeholder(fn ($record) => $record.'.'))
        ->toBeInstanceOf(HasPlaceholderComponent::class)
        ->resolvePlaceholder(['record' => 'Placeholder'])->toBe('Placeholder.')
        ->getPlaceholder()->toBe('Placeholder.');
});
