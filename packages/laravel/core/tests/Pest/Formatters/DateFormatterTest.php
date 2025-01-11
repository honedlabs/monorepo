<?php

use Carbon\Carbon;
use Honed\Core\Formatters\DateFormatter;

beforeEach(function () {
    $this->formatter = DateFormatter::make();
});

it('makes', function () {
    expect(DateFormatter::make())
        ->toBeInstanceOf(DateFormatter::class);
});

it('defaults to d/m/Y', function () {
    expect($this->formatter->getDate())->toBe('d/m/Y');
});

it('sets date', function () {
    expect($this->formatter->date('dd-mm-yyyy'))
        ->toBeInstanceOf(DateFormatter::class)
        ->getDate()->toBe('dd-mm-yyyy');
});

it('sets timezone', function () {
    expect($this->formatter->timezone('Europe/London'))
        ->toBeInstanceOf(DateFormatter::class)
        ->getTimezone()->toBe('Europe/London')
        ->hasTimezone()->toBeTrue();
});

it('sets since', function () {
    expect($this->formatter->since())
        ->toBeInstanceOf(DateFormatter::class)
        ->isSince()->toBeTrue();
});

it('formats', function () {
    Carbon::setTestNow('2000-01-02');

    expect($this->formatter->format('2000-01-01'))->toBe('01/01/2000');

    expect($this->formatter->date('Y')->format('2000-01-01'))->toBe('2000');

    expect($this->formatter->since()->format('2000-01-01'))->toBe('1 day ago');

    expect($this->formatter->format(null))->toBeNull();

    expect($this->formatter->format('testing'))->toBeNull();
});
