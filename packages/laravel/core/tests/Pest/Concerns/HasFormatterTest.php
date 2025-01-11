<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasFormatter;
use Honed\Core\Formatters\BooleanFormatter;
use Honed\Core\Formatters\DateFormatter;
use Honed\Core\Formatters\NumericFormatter;
use Honed\Core\Formatters\StringFormatter;

class FormatterTest
{
    use HasFormatter;
}

beforeEach(function () {
    $this->test = new FormatterTest;
});

it('sets', function () {
    expect($this->test->formatter(BooleanFormatter::make()))
        ->toBeInstanceOf(FormatterTest::class)
        ->hasFormatter()->toBeTrue();
});

it('sets boolean', function () {
    expect($this->test->formatBoolean())
        ->toBeInstanceOf(FormatterTest::class)
        ->getFormatter()->toBeInstanceOf(BooleanFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('sets date formatter', function () {
    expect($this->test->formatDate())
        ->toBeInstanceOf(FormatterTest::class)
        ->getFormatter()->toBeInstanceOf(DateFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('sets numeric formatter', function () {
    expect($this->test->formatNumeric())
        ->toBeInstanceOf(FormatterTest::class)
        ->getFormatter()->toBeInstanceOf(NumericFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('sets string formatter', function () {
    expect($this->test->formatString())
        ->toBeInstanceOf(FormatterTest::class)
        ->getFormatter()->toBeInstanceOf(StringFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('formats', function () {
    expect($this->test->format('value'))->toBe('value');

    expect($this->test->formatBoolean()->format('value'))->toBe('True');
});
