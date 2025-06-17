<?php

declare(strict_types=1);

use Honed\Infolist\Entries\Entry;

beforeEach(function () {
    $this->entry = Entry::make('name');
});

it('can be array', function () {
    expect($this->entry)
        ->isArray()->toBeFalse()
        ->array()->toBe($this->entry)
        ->isArray()->toBeTrue()
        ->format([])->toBe([])
        ->format(null)->toBeNull();
});

it('can be boolean', function () {
    expect($this->entry)
        ->isBoolean()->toBeFalse()
        ->boolean()->toBe($this->entry)
        ->isBoolean()->toBeTrue()
        ->trueText('Yes')
        ->falseText('No')
        ->format(true)->toBe('Yes')
        ->format(false)->toBe('No');
});

it('can be date', function () {
    expect($this->entry)
        ->isDate()->toBeFalse()
        ->date()->toBe($this->entry)
        ->isDate()->toBeTrue()
        ->format(now())->toBe(now()->format('Y-m-d'))
        ->format(null)->toBeNull();
});

it('can be date time', function () {
    expect($this->entry)
        ->isDateTime()->toBeFalse()
        ->dateTime()->toBe($this->entry)
        ->isDateTime()->toBeTrue()
        ->format(now())->toBe(now()->format('Y-m-d H:i:s'))
        ->format(null)->toBeNull();
});

it('can be image', function () {
    expect($this->entry)
        ->isImage()->toBeFalse()
        ->image()->toBe($this->entry)
        ->isImage()->toBeTrue()
        ->format('https://example.com/image.jpg')->toBe('https://example.com/image.jpg')
        ->format(null)->toBeNull();
});

it('can be numeric', function () {
    expect($this->entry)
        ->isNumeric()->toBeFalse()
        ->numeric()->toBe($this->entry)
        ->isNumeric()->toBeTrue()
        ->format(100)->toBe('100')
        ->format(null)->toBeNull();
});

it('can be text', function () {
    expect($this->entry)
        ->isText()->toBeFalse()
        ->text()->toBe($this->entry)
        ->isText()->toBeTrue()
        ->format('Hello')->toBe('Hello')
        ->format(null)->toBeNull();
});

it('can be time', function () {
    expect($this->entry)
        ->isTime()->toBeFalse()
        ->time()->toBe($this->entry)
        ->isTime()->toBeTrue()
        ->format(now())->toBe(now()->format('H:i:s'))
        ->format(null)->toBeNull();
});
