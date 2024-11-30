<?php

use Honed\Core\Formatters\StringFormatter;

beforeEach(function () {
    $this->formatter = StringFormatter::make();
});

it('has no suffix by default', function () {
    expect($this->formatter->hasSuffix())->toBeFalse();
    expect($this->formatter->missingSuffix())->toBeTrue();
});

it('can set a suffix', function () {
    expect($this->formatter->suffix('.'))->toBeInstanceOf(StringFormatter::class)
        ->getSuffix()->toBe('.');
});

it('can be set using setter', function () {
    $this->formatter->setSuffix('.');
    expect($this->formatter->getSuffix())->toBe('.');
});

it('does not accept null values', function () {
    $this->formatter->setSuffix('.');
    $this->formatter->setSuffix(null);
    expect($this->formatter->getSuffix())->toBe('.');
});

