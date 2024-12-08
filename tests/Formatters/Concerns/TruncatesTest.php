<?php

use Honed\Core\Formatters\StringFormatter;

beforeEach(function () {
    $this->formatter = StringFormatter::make();
});

it('has no truncate value by default', function () {
    expect($this->formatter->hasTruncate())->toBeFalse();
    expect($this->formatter->missingTruncate())->toBeTrue();
});

it('can set a divide by value', function () {
    expect($this->formatter->truncate(100))->toBeInstanceOf(StringFormatter::class)
        ->getTruncate()->toBe(100);
});

it('can be set using setter', function () {
    $this->formatter->setTruncate(100);
    expect($this->formatter->getTruncate())->toBe(100);
});

it('does not accept null values', function () {
    $this->formatter->setTruncate(100);
    $this->formatter->setTruncate(null);
    expect($this->formatter->getTruncate())->toBe(100);
});
