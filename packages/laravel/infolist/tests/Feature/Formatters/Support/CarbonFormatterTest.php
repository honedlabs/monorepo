<?php

declare(strict_types=1);

use Honed\Infolist\Formatters\DateFormatter;

beforeEach(function () {
    $this->freezeTime();

    $this->formatter = new DateFormatter();
});

it('has date format', function () {
    expect($this->formatter)
        ->getDateFormat()->toBeString()
        ->using('d/m/Y')->toBe($this->formatter)
        ->getDateFormat()->toBe('d/m/Y');
});

it('has since', function () {
    expect($this->formatter)
        ->isSince()->toBeFalse()
        ->since()->toBe($this->formatter)
        ->isSince()->toBeTrue();
});

it('has timezone', function () {
    expect($this->formatter)
        ->getTimezone()->toBeNull()
        ->timezone('America/New_York')->toBe($this->formatter)
        ->getTimezone()->toBe('America/New_York');
});

it('handles null values', function () {
    expect($this->formatter)
        ->format(null)->toBeNull();
});

it('formats dates', function () {
    expect($this->formatter)
        ->format(now())->toBe(now()->format($this->formatter->getDateFormat()))
        ->format('2025-01-01')->toBe('2025-01-01');
});

it('formats dates with time zone', function () {
    $date = '2025-01-15 12:00:00';
    expect($this->formatter)
        ->timezone('America/New_York')->toBe($this->formatter)
        ->format($date)->toBe(Carbon\Carbon::parse($date, 'America/New_York')->format($this->formatter->getDateFormat()));
});

it('formats dates with since', function () {
    expect($this->formatter)
        ->since()->toBe($this->formatter)
        ->format(now())->toBe(now()->diffForHumans());
});

it('prevents invalid values', function () {
    expect($this->formatter)
        ->format('invalid')->toBeNull();
});
