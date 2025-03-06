<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasFormatter;
use Honed\Core\Formatters\BooleanFormatter;
use Honed\Core\Formatters\DateFormatter;
use Honed\Core\Formatters\NumberFormatter;
use Honed\Core\Formatters\StringFormatter;

beforeEach(function () {
    $this->test = new class
    {
        use Evaluable;
        use HasFormatter;

        protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
        {
            return match ($parameterName) {
                'formatter' => $this->formatter,
                default => [],
            };
        }
    };
});

it('sets', function () {
    expect($this->test->formatter(BooleanFormatter::make()))
        ->toBe($this->test)
        ->hasFormatter()->toBeTrue();
});

it('sets boolean', function () {
    expect($this->test->formatBoolean())
        ->toBe($this->test)
        ->getFormatter()->toBeInstanceOf(BooleanFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('sets date formatter', function () {
    expect($this->test->formatDate())
        ->toBe($this->test)
        ->getFormatter()->toBeInstanceOf(DateFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('sets number formatter', function () {
    expect($this->test->formatNumber())
        ->toBe($this->test)
        ->getFormatter()->toBeInstanceOf(NumberFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('sets string formatter', function () {
    expect($this->test->formatString())
        ->toBe($this->test)
        ->getFormatter()->toBeInstanceOf(StringFormatter::class)
        ->hasFormatter()->toBeTrue();
});

it('formats', function () {
    expect($this->test->format('value'))->toBe('value');

    expect($this->test->formatBoolean()->format('value'))->toBe('True');
});
