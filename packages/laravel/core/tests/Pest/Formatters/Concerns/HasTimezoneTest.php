<?php

use Honed\Core\Formatters\DateFormatter;

beforeEach(function () {
    $this->formatter = DateFormatter::make();
});

it('has no timezone by default', function () {
    expect($this->formatter->hasTimezone())->toBeFalse();
});

it('can set a timezone', function () {
    expect($this->formatter->timezone('.'))->toBeInstanceOf(DateFormatter::class)
        ->getTimezone()->toBe('.');
});

it('can be set using setter', function () {
    $this->formatter->setTimezone('.');
    expect($this->formatter->getTimezone())->toBe('.');
});

it('rejects null values', function () {
    $this->formatter->setTimezone('.');
    $this->formatter->setTimezone(null);
    expect($this->formatter->getTimezone())->toBe('.');
});
