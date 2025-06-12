<?php

declare(strict_types=1);

use Honed\Refine\Refine;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->refine = Refine::make(User::class);
});

it('has a before callback', function () {
    expect($this->refine)
        ->getBeforeCallback()->toBeNull()
        ->before(fn () => 'before')->toBe($this->refine)
        ->getBeforeCallback()->toBeInstanceOf(Closure::class);
});

it('has am after callback', function () {
    expect($this->refine)
        ->getAfterCallback()->toBeNull()
        ->after(fn () => 'after')->toBe($this->refine)
        ->getAfterCallback()->toBeInstanceOf(Closure::class);
});
