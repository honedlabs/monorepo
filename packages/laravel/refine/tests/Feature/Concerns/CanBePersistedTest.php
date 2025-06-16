<?php

declare(strict_types=1);

use Honed\Refine\Refine;
use Workbench\App\Models\User;
use Workbench\App\Refiners\RefineUser;
use Honed\Refine\Persistence\CookieDriver;
use Honed\Refine\Persistence\SessionDriver;

beforeEach(function () {
    $this->refine = Refine::make(User::class);
});

it('sets persist key', function () {
    expect($this->refine)
        ->getPersistKey()->toBe('refine')
        ->persistKey('key')->toBe($this->refine)
        ->getPersistKey()->toBe('key');

    expect(RefineUser::make())
        ->getPersistKey()->toBe('refine-user');
});

it('sets driver', function () {
    expect($this->refine)
        ->getPersistDriver(true)->toBeInstanceOf(SessionDriver::class)
        ->persistInCookie()->toBe($this->refine)
        ->getPersistDriver(true)->toBeInstanceOf(CookieDriver::class)
        ->persistInSession()->toBe($this->refine)
        ->getPersistDriver(true)->toBeInstanceOf(SessionDriver::class);
});

it('sets lifetime', function () {
    expect($this->refine)
        ->lifetime(10)->toBe($this->refine);
});