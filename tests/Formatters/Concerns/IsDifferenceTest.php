<?php

use Honed\Core\Formatters\DateFormatter;

beforeEach(function () {
    $this->formatter = DateFormatter::make();
});

it('can set difference', function () {
    $this->formatter->setDifference(true);
    expect($this->formatter->isDifference())->toBeTrue();
});

it('prevents null values', function () {
    $this->formatter->setDifference(null);
    expect($this->formatter->isDifference())->toBeFalse();
});

it('can set closure difference', function () {
    $this->formatter->setDifference(fn () => true);
    expect($this->formatter->isDifference())->toBeTrue();
});

it('defaults to false', function () {
    expect($this->formatter->isDifference())->toBeFalse();
});

it('can chain difference', function () {
    expect($this->formatter->difference(true))->toBeInstanceOf(DateFormatter::class);
    expect($this->formatter->isDifference())->toBeTrue();
});

it('checks if difference', function () {
    expect($this->formatter->isDifference())->toBeFalse();
    expect($this->formatter->isNotDifference())->toBeTrue();
    $this->formatter->setDifference(true);
    expect($this->formatter->isDifference())->toBeTrue();
    expect($this->formatter->isNotDifference())->toBeFalse();
});

it('has alias since', function () {
    expect($this->formatter->since())->toBeInstanceOf(DateFormatter::class);
    expect($this->formatter->isDifference())->toBeTrue();
});

it('has alias diff', function () {
    expect($this->formatter->diff())->toBeInstanceOf(DateFormatter::class);
    expect($this->formatter->isNotDifference())->toBeTrue();
});
