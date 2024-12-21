<?php

use Honed\Core\Formatters\BooleanFormatter;
use Honed\Core\Formatters\Concerns\Formattable;
use Honed\Core\Formatters\CurrencyFormatter;
use Honed\Core\Formatters\DateFormatter;
use Honed\Core\Formatters\NumberFormatter;
use Honed\Core\Formatters\StringFormatter;

class FormattableComponent
{
    use Formattable;
}

beforeEach(function () {
    $this->component = new FormattableComponent;
});

it('has no formatter by default', function () {
    expect($this->component->hasFormatter())->toBeFalse();
    expect($this->component->missingFormatter())->toBeTrue();
});

it('can set a formatter', function () {
    expect($this->component->formatter(DateFormatter::make()))->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->missingFormatter()->toBeFalse()
        ->getFormatter()->toBeInstanceOf(DateFormatter::class);
});

it('does not accept null values', function () {
    expect($this->component->formatter(DateFormatter::make()))
        ->hasFormatter()->toBeTrue();

    $this->component->setFormatter(null);

    expect($this->component)
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(DateFormatter::class);
});

it('can format a value using the given formatter', function () {
    expect($this->component->formatter(DateFormatter::make())->format('2024-01-01'))->toBe('01/01/2024');
});

it('does not format a value if there is no formatter', function () {
    expect($this->component->format('2024-01-01'))->toBe('2024-01-01');
});

it('has a shorthand for setting a boolean formatter', function () {
    expect($this->component->boolean())->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->missingFormatter()->toBeFalse()
        ->getFormatter()->toBeInstanceOf(BooleanFormatter::class);
});

it('has a shorthand for setting a string formatter', function () {
    expect($this->component->string())->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->missingFormatter()->toBeFalse()
        ->getFormatter()->toBeInstanceOf(StringFormatter::class);
});

it('has a shorthand for setting a date formatter', function () {
    expect($this->component->date())->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->missingFormatter()->toBeFalse()
        ->getFormatter()->toBeInstanceOf(DateFormatter::class);
});

it('has a shorthand for setting a number formatter', function () {
    expect($this->component->number())->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->missingFormatter()->toBeFalse()
        ->getFormatter()->toBeInstanceOf(NumberFormatter::class);
});

it('has a shorthand for setting a currency formatter', function () {
    expect($this->component->currency())->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->missingFormatter()->toBeFalse()
        ->getFormatter()->toBeInstanceOf(CurrencyFormatter::class);
});
