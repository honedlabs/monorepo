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
});

it('sets formatter', function () {
    $this->component->setFormatter(DateFormatter::make());
    expect($this->component)
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(DateFormatter::class);
});

it('rejects null values', function () {
    $this->component->formatter(DateFormatter::make());
    $this->component->setFormatter(null);

    expect($this->component)
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(DateFormatter::class);
});

it('chains formatter', function () {
    expect($this->component->formatter(DateFormatter::make()))->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(DateFormatter::class);
});

it('can format', function () {
    expect($this->component->formatter(DateFormatter::make())
        ->format('2024-01-01'))->toBe('01/01/2024');
});

it('does not mutate if no formatter', function () {
    expect($this->component->format('2024-01-01'))->toBe('2024-01-01');
});

it('has shorthand `boolean`', function () {
    expect($this->component->boolean())->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(BooleanFormatter::class);
});

it('has shorthand `string`', function () {
    expect($this->component->string())->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(StringFormatter::class);
});

it('has shorthand `date`', function () {
    expect($this->component->date())->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(DateFormatter::class);
});

it('has shorthand `number`', function () {
    expect($this->component->number())->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(NumberFormatter::class);
});

it('has shorthand `currency`', function () {
    expect($this->component->currency())->toBeInstanceOf(FormattableComponent::class)
        ->hasFormatter()->toBeTrue()
        ->getFormatter()->toBeInstanceOf(CurrencyFormatter::class);
});
