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

it('formats a string value', function () {
    $this->formatter->setPrefix('#');
    $this->formatter->setSuffix('.');
    $this->formatter->setTruncate(3);
    expect($this->formatter->format('value'))->toBe('#val....');
});

it('formats a numeric value', function () {
    $this->formatter->setPrefix('ID: ');
    expect($this->formatter->format(123))->toBe('ID: 123');
});

it('rejects null values from formatting', function () {
    expect($this->formatter->format(null))->toBeNull();
});
