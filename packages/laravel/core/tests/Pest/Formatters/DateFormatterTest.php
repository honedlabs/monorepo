<?php

use Carbon\Carbon;
use Honed\Core\Formatters\DateFormatter;

beforeEach(function () {
    $this->formatter = DateFormatter::make();
});

it('can be made', function () {
    $formatter = DateFormatter::make();
    expect($formatter)->toBeInstanceOf(DateFormatter::class);
});

it('accepts arguments', function () {
    $formatter = DateFormatter::make('d M Y', true, 'Europe/London');
    expect($formatter->getDateFormat())->toBe('d M Y');
    expect($formatter->getTimezone())->toBe('Europe/London');
    expect($formatter->isDifference())->toBeTrue();
});

it('parses and formats a string value', function () {
    expect($this->formatter->format('january 1st 2000'))->toBe('01/01/2000');
});

it('parses and formats using difference', function () {
    Carbon::setTestNow('2000-01-02');
    expect($this->formatter->since()->format('2000-01-01'))->toBe('1 day ago');
});

it('hides values which could not be parsed', function () {
    expect($this->formatter->format('invalid date'))->toBeNull();
});

it('rejects null values from formatting', function () {
    expect($this->formatter->format(null))->toBeNull();
});