<?php

use Honed\Core\Formatters\BooleanFormatter;

beforeEach(function () {
    BooleanFormatter::useFalseLabel();
    $this->formatter = BooleanFormatter::make();
});

it('has a default false label', function () {
    expect($this->formatter->getFalseLabel())->toBe(BooleanFormatter::FalseLabel);
});

it('can set a false label', function () {
    expect($this->formatter->falseLabel('No'))->toBeInstanceOf(BooleanFormatter::class)
        ->getFalseLabel()->toBe('No');
});

it('can be set using setter', function () {
    $this->formatter->setFalseLabel('No');
    expect($this->formatter->getFalseLabel())->toBe('No');
});

it('does not accept null values', function () {
    $this->formatter->setFalseLabel(null);
    expect($this->formatter->getFalseLabel())->toBe(BooleanFormatter::FalseLabel);
});

it('can be configured globally', function () {
    BooleanFormatter::useFalseLabel('No');
    expect(BooleanFormatter::make()->getFalseLabel())->toBe('No');
});

it('has alias ifFalse', function () {
    expect($this->formatter->ifFalse('No'))->toBeInstanceOf(BooleanFormatter::class)
        ->getFalseLabel()->toBe('No');
});
