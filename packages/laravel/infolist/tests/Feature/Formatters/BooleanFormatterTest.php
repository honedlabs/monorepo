<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\BooleanFormatter;

beforeEach(function () {
    $this->formatter = new BooleanFormatter();
});

it('has true text', function () {
    expect($this->formatter)
        ->getTrueText()->toBeNull()
        ->trueText('Yes')->toBe($this->formatter)
        ->getTrueText()->toBe('Yes');
});

it('has false text', function () {
    expect($this->formatter)
        ->getFalseText()->toBeNull()
        ->falseText('No')->toBe($this->formatter)
        ->getFalseText()->toBe('No');
});

it('handles null values', function () {
    expect($this->formatter)
        ->falseText('False')->toBe($this->formatter)
        ->format(null)->toBe('False');
});

it('formats booleans', function () {
    expect($this->formatter)
        ->trueText('True')->toBe($this->formatter)
        ->falseText('False')->toBe($this->formatter)
        ->format(true)->toBe('True')
        ->format(false)->toBe('False')
        ->format(null)->toBe('False')
        ->format('value')->toBe('True')
        ->format('')->toBe('False');
});
