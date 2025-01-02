<?php

use Honed\Core\Formatters\BooleanFormatter;

beforeEach(function () {
    BooleanFormatter::useTruthLabel();
    $this->formatter = BooleanFormatter::make();
});

it('has a default truth label', function () {
    expect($this->formatter->getTruthLabel())->toBe(BooleanFormatter::TruthLabel);
});

it('can set a truth label', function () {
    expect($this->formatter->truthLabel('No'))->toBeInstanceOf(BooleanFormatter::class)
        ->getTruthLabel()->toBe('No');
});

it('can be set using setter', function () {
    $this->formatter->setTruthLabel('No');
    expect($this->formatter->getTruthLabel())->toBe('No');
});

it('does not accept null values', function () {
    $this->formatter->setTruthLabel(null);
    expect($this->formatter->getTruthLabel())->toBe(BooleanFormatter::TruthLabel);
});

it('can be configured globally', function () {
    BooleanFormatter::useTruthLabel('No');
    expect(BooleanFormatter::make()->getTruthLabel())->toBe('No');
});

it('has alias ifTrue', function () {
    expect($this->formatter->ifTrue('No'))->toBeInstanceOf(BooleanFormatter::class)
        ->getTruthLabel()->toBe('No');
});
