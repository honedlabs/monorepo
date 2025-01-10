<?php

use Honed\Core\Formatters\StringFormatter;

beforeEach(function () {
    $this->formatter = StringFormatter::make();
});

it('makes', function () {
    expect(StringFormatter::make())
        ->toBeInstanceOf(StringFormatter::class);
});

it('sets prefix', function () {
    expect($this->formatter->prefix('#'))
        ->toBeInstanceOf(StringFormatter::class)
        ->prefix()->toBe('#')
        ->hasPrefix()->toBeTrue();
});

it('sets suffix', function () {
    expect($this->formatter->suffix('.'))
        ->toBeInstanceOf(StringFormatter::class)
        ->suffix()->toBe('.')
        ->hasSuffix()->toBeTrue();
});

it('sets limit', function () {
    expect($this->formatter->limit(3))
        ->toBeInstanceOf(StringFormatter::class)
        ->limit()->toBe(3)
        ->hasLimit()->toBeTrue();
});

it('formats', function () {
    expect($this->formatter->format('value'))->toBe('value');

    expect($this->formatter->prefix('#')->format(123))->toBe('#123');

    expect($this->formatter->suffix('.'))->format('value')->toBe('#value.');

    expect($this->formatter->limit(3))->format('value')->toBe('#val....');

    expect($this->formatter->format(null))->toBeNull();
});
