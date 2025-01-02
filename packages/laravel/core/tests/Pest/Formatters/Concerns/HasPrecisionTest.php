<?php

declare(strict_types=1);

use Honed\Core\Formatters\Concerns\HasPrecision;

class HasPrecisionComponent
{
    use HasPrecision;
}

beforeEach(function () {
    $this->component = new HasPrecisionComponent;
});

it('has no precision by default', function () {
    expect($this->component)
        ->getPrecision()->toBeNull()
        ->hasPrecision()->toBeFalse();
});

it('sets precision', function () {
    $this->component->setPrecision(100);
    expect($this->component)
        ->getPrecision()->toBe(100)
        ->hasPrecision()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setPrecision(100);
    $this->component->setPrecision(null);
    expect($this->component)
        ->getPrecision()->toBe(100)
        ->hasPrecision()->toBeTrue();
});

it('chains precision', function () {
    expect($this->component->precision(100))->toBeInstanceOf(HasPrecisionComponent::class)
        ->getPrecision()->toBe(100)
        ->hasPrecision()->toBeTrue();
});
