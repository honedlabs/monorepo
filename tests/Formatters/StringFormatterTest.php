<?php

use Honed\Core\Formatters\StringFormatter;

beforeEach(function () {
    $this->formatter = StringFormatter::make();
});

it('can be made', function () {
    $formatter = StringFormatter::make();
    expect($formatter)->toBeInstanceOf(StringFormatter::class);
});

it('accepts a prefix and suffix', function () {
    $formatter = StringFormatter::make('#', '.');
    expect($formatter->getPrefix())->toBe('#');
    expect($formatter->getSuffix())->toBe('.');
});

it('can format a string value', function () {
    $this->formatter->setPrefix('#');
    $this->formatter->setSuffix('.');
    expect($this->formatter->format('value'))->toBe('#value.');
});

it('can format a numeric value', function () {
    $this->formatter->setPrefix('ID: ');
    expect($this->formatter->format(123))->toBe('ID: 123');
});

it('can format a boolean value', function () {
    $this->formatter->setPrefix('Is: ');
    // Usually boolean formatters would be used here
    expect($this->formatter->format(true))->toBe('Is: 1');
    expect($this->formatter->format(false))->toBe('Is: 0');
});

