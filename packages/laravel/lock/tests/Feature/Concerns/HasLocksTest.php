<?php

declare(strict_types=1);

use Honed\Lock\Facades\Lock;
use Illuminate\Database\Eloquent\Casts\Attribute;

beforeEach(function () {
    $this->product = product();
    Lock::appendToModels(false);
});

it('initializes', function () {
    expect($this->product)
        ->isLocking()->toBeFalse()
        ->withLocks()->toBe($this->product)
        ->isLocking()->toBeTrue()
        ->withoutLocks()->toBe($this->product)
        ->isLocking()->toBeFalse();

    Lock::appendToModels(true);

    expect(product())
        ->isLocking()->toBeTrue();
});

it('has locks', function () {
    expect($this->product)
        ->locks()->toBe($this->product);
});

it('has lock attribute', function () {
    expect($this->product)
        ->lock()->toBeInstanceOf(Attribute::class);
});

it('gets locks', function () {
    expect($this->product)
        ->getLocks()->toBeArray();
});
