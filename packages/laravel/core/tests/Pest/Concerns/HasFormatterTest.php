<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasFormatter;
use Honed\Core\Formatters\DateFormatter;
use Honed\Core\Formatters\StringFormatter;
use Honed\Core\Formatters\BooleanFormatter;
use Honed\Core\Formatters\NumericFormatter;

class FormatterTest
{
    use HasFormatter;
}

beforeEach(function (){
    $this->test = new FormatterTest;
});

it('sets formatter', function () {
    expect($this->test->formatter(BooleanFormatter::make()))
        ->toBeInstanceOf(FormatterTest::class)
        ->formatter()->toBeInstanceOf(BooleanFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('sets boolean formatter', function () {
    expect($this->test->formatBoolean())
        ->toBeInstanceOf(FormatterTest::class)
        ->formatter()->toBeInstanceOf(BooleanFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('sets date formatter', function () {
    expect($this->test->formatDate())
        ->toBeInstanceOf(FormatterTest::class)
        ->formatter()->toBeInstanceOf(DateFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('sets numeric formatter', function () {
    expect($this->test->formatNumeric())
        ->toBeInstanceOf(FormatterTest::class)
        ->formatter()->toBeInstanceOf(NumericFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('sets string formatter', function () {
    expect($this->test->formatString())
        ->toBeInstanceOf(FormatterTest::class)
        ->formatter()->toBeInstanceOf(StringFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('formats', function () {
    expect($this->test->format('value'))->toBe('value');

    expect($this->test->formatBoolean()->format('value'))->toBe('True');
});