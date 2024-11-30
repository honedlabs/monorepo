<?php

use Honed\Core\Formatters\BooleanFormatter;

beforeEach(function () {
    BooleanFormatter::setDefaultTruthLabel();
    $this->formatter = BooleanFormatter::make();
});

it('has a default truth label', function () {
    expect($this->formatter->getTruthLabel())->toBe(BooleanFormatter::DefaultTruthLabel);
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
    expect($this->formatter->getTruthLabel())->toBe(BooleanFormatter::DefaultTruthLabel);
});

it('can be configured globally', function () {
    BooleanFormatter::setDefaultTruthLabel('No');
    expect(BooleanFormatter::make()->getTruthLabel())->toBe('No');
});

it('has alias ifTrue', function () {
    expect($this->formatter->ifTrue('No'))->toBeInstanceOf(BooleanFormatter::class)
        ->getTruthLabel()->toBe('No');
});
