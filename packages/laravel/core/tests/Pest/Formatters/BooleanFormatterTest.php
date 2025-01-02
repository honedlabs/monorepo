<?php

use Honed\Core\Formatters\BooleanFormatter;

beforeEach(function () {
    BooleanFormatter::useTruthLabel();
    BooleanFormatter::useFalseLabel();
    $this->formatter = BooleanFormatter::make();
});

it('can be made', function () {
    expect(BooleanFormatter::make())->toBeInstanceOf(BooleanFormatter::class)
        ->getTruthLabel()->toBe(BooleanFormatter::TruthLabel)
        ->getFalseLabel()->toBe(BooleanFormatter::FalseLabel);
});

it('accepts a truth and false label', function () {
    expect(BooleanFormatter::make('Yes', 'No'))
        ->getTruthLabel()->toBe('Yes')
        ->getFalseLabel()->toBe('No');
});

it('formats a boolean value', function () {
    expect($this->formatter->format(true))->toBe(BooleanFormatter::TruthLabel);
    expect($this->formatter->format(false))->toBe(BooleanFormatter::FalseLabel);
});

it('formats a string value', function () {
    expect($this->formatter->format('a'))->toBe(BooleanFormatter::TruthLabel);
    expect($this->formatter->format(''))->toBe(BooleanFormatter::FalseLabel);
});

it('formats a numeric value', function () {
    expect($this->formatter->format(1))->toBe(BooleanFormatter::TruthLabel);
    expect($this->formatter->format(0))->toBe(BooleanFormatter::FalseLabel);
});

it('sets the boolean labels', function () {
    expect($this->formatter->labels('Yes', 'No'))->toBeInstanceOf(BooleanFormatter::class)
        ->getTruthLabel()->toBe('Yes')
        ->getFalseLabel()->toBe('No');
});
