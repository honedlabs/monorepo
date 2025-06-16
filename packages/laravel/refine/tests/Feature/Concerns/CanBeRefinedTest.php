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

it('has an after callback', function () {
    expect($this->refine)
        ->getAfterCallback()->toBeNull()
        ->after(fn () => 'after')->toBe($this->refine)
        ->getAfterCallback()->toBeInstanceOf(Closure::class);
});

it('has array representation', function () {
    expect($this->refine->toArray())->toBeArray()
        ->toHaveKeys([
            'sort',
            'search',
            'match',
            'term',
            'delimiter',
            'placeholder',
            'sorts',
            'filters',
            'searches',
        ]);
});
