<?php

use Honed\Core\Formatters\BooleanFormatter;

beforeAll(function () {
    BooleanFormatter::setDefaultTruthLabel();
    BooleanFormatter::setDefaultFalseLabel();
});

it('can be made', function () {
    $formatter = BooleanFormatter::make();
    expect($formatter)->toBeInstanceOf(BooleanFormatter::class);
});

it('accepts a truth and false label', function () {
    $formatter = BooleanFormatter::make('Yes', 'No');
    expect($formatter->getTruthLabel())->toBe('Yes');
    expect($formatter->getFalseLabel())->toBe('No');
});

it('can format a boolean value', function () {
    $formatter = BooleanFormatter::make();
    expect($formatter->format(true))->toBe(BooleanFormatter::DefaultTruthLabel);
    expect($formatter->format(false))->toBe(BooleanFormatter::DefaultFalseLabel);
});

it('can format a string value', function () {
    $formatter = BooleanFormatter::make();
    expect($formatter->format('a'))->toBe(BooleanFormatter::DefaultTruthLabel);
    expect($formatter->format(''))->toBe(BooleanFormatter::DefaultFalseLabel);
});

it('can format a numeric value', function () {
    $formatter = BooleanFormatter::make();
    expect($formatter->format(1))->toBe(BooleanFormatter::DefaultTruthLabel);
    expect($formatter->format(0))->toBe(BooleanFormatter::DefaultFalseLabel);
});
