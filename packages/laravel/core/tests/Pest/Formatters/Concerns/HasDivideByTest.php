<?php

declare(strict_types=1);

use Honed\Core\Formatters\Concerns\HasDivideBy;

class HasDivideByComponent
{
    use HasDivideBy;
}

beforeEach(function () {
    $this->component = new HasDivideByComponent;
});

it('has no divide by by default', function () {
    expect($this->component)
        ->getDivideBy()->toBeNull()
        ->hasDivideBy()->toBeFalse();
});

it('sets divide by', function () {
    $this->component->setDivideBy(100);
    expect($this->component)
        ->getDivideBy()->toBe(100)
        ->hasDivideBy()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setDivideBy(100);
    $this->component->setDivideBy(null);
    expect($this->component)
        ->getDivideBy()->toBe(100)
        ->hasDivideBy()->toBeTrue();
});

it('chains divide by', function () {
    expect($this->component->divideBy(100))->toBeInstanceOf(HasDivideByComponent::class)
        ->getDivideBy()->toBe(100)
        ->hasDivideBy()->toBeTrue();
});
