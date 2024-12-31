<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasFormat;

class HasFormatComponent
{
    use HasFormat;
    use Evaluable;
}

beforeEach(function () {
    $this->component = new HasFormatComponent;
});

it('has no format by default', function () {
    expect($this->component)
        ->getFormat()->toBeNull()
        ->hasFormat()->toBeFalse();
});

it('sets format', function () {
    $this->component->setFormat($p = 'Format');
    expect($this->component)
        ->getFormat()->toBe($p)
        ->hasFormat()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setFormat('Format');
    $this->component->setFormat(null);
    expect($this->component)
        ->getFormat()->toBe('Format')
        ->hasFormat()->toBeTrue();
});

it('chains format', function () {
    expect($this->component->format($p = 'Format'))->toBeInstanceOf(HasFormatComponent::class)
        ->getFormat()->toBe($p)
        ->hasFormat()->toBeTrue();
});

it('resolves format', function () {
    expect($this->component->format(fn ($record) => $record.'.'))
        ->toBeInstanceOf(HasFormatComponent::class)
        ->resolveFormat(['record' => 'Format'])->toBe('Format.')
        ->getFormat()->toBe('Format.');
});