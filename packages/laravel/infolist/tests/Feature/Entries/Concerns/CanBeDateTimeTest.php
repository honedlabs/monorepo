<?php

use Honed\Infolist\Entries\DateTimeEntry;

beforeEach(function () {
    $this->entry = DateTimeEntry::make('created_at');
});

it('can be date', function () {
    expect($this->entry)
        ->isDate()->toBeFalse()
        ->date()->toBe($this->entry)
        ->isDate()->toBeTrue()
        ->format(now())->toBe(now()->format('Y-m-d'))
        ->format(null)->toBeNull()
        ->format('invalid')->toBeNull();
});

it('can be date with format', function () {
    expect($this->entry)
        ->getDateFormat()->toBe('Y-m-d')
        ->dateFormat('d/m/Y')
        ->getDateFormat()->toBe('d/m/Y')
        ->format(now())->toBe(now()->format('d/m/Y'))
        ->format(null)->toBeNull()
        ->format('invalid')->toBeNull();
});

it('can be date time', function () {
    expect($this->entry)
        ->isDateTime()->toBeFalse()
        ->dateTime()->toBe($this->entry)
        ->isDateTime()->toBeTrue()
        ->format(now())->toBe(now()->format('Y-m-d H:i:s'))
        ->format(null)->toBeNull()
        ->format('invalid')->toBeNull();
});

it('can be date time with format', function () {
    expect($this->entry)
        ->getDateTimeFormat()->toBe('Y-m-d H:i:s')
        ->dateTimeFormat('d/m/Y H:i:s')
        ->getDateTimeFormat()->toBe('d/m/Y H:i:s')
        ->format(now())->toBe(now()->format('d/m/Y H:i:s'))
        ->format(null)->toBeNull()
        ->format('invalid')->toBeNull();
});

it('can be time', function () {
    expect($this->entry)
        ->isTime()->toBeFalse()
        ->time()->toBe($this->entry)
        ->isTime()->toBeTrue()
        ->format(now())->toBe(now()->format('H:i:s'))
        ->format(null)->toBeNull()
        ->format('invalid')->toBeNull();
});

it('can be time with format', function () {
    expect($this->entry)
        ->getTimeFormat()->toBe('H:i:s')
        ->timeFormat('d/m/Y H:i:s')
        ->getTimeFormat()->toBe('d/m/Y H:i:s')
        ->format(now())->toBe(now()->format('d/m/Y H:i:s'))
        ->format(null)->toBeNull()
        ->format('invalid')->toBeNull();
});

it('can be since', function () {
    expect($this->entry)
        ->isSince()->toBeFalse()
        ->since()->toBe($this->entry)
        ->isSince()->toBeTrue()
        ->format(now())->toBe(now()->diffForHumans())
        ->format(null)->toBeNull()
        ->format('invalid')->toBeNull();
});