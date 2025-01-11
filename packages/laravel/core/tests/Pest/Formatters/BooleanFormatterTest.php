<?php

use Honed\Core\Formatters\BooleanFormatter;

beforeEach(function () {
    $this->formatter = BooleanFormatter::make();
});

it('makes', function () {
    expect(BooleanFormatter::make())
        ->toBeInstanceOf(BooleanFormatter::class);
});

it('sets true', function () {
    expect($this->formatter->true('Yes'))
        ->toBeInstanceOf(BooleanFormatter::class)
        ->getTrue()->toBe('Yes');
});

it('sets false', function () {
    expect($this->formatter->false('No'))
        ->toBeInstanceOf(BooleanFormatter::class)
        ->getFalse()->toBe('No');
});

it('sets labels', function () {
    expect($this->formatter->labels('Yes', 'No'))
        ->toBeInstanceOf(BooleanFormatter::class)
        ->getTrue()->toBe('Yes')
        ->getFalse()->toBe('No');
});

it('formats', function () {
    expect($this->formatter->format(true))->toBe('True');
    expect($this->formatter->format(false))->toBe('False');
});
