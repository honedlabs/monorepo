<?php

declare(strict_types=1);

use Honed\Stats\Profile;

beforeEach(function () {
    $this->profile = Profile::make();
});

it('can defer', function () {
    expect($this->profile)
        ->getDeferStrategy()->toBe('defer')
        ->defer('lazy')->toBe($this->profile)
        ->getDeferStrategy()->toBe('lazy');
});

it('can be lazy', function () {
    expect($this->profile)
        ->isLazy()->toBeFalse()
        ->lazy()->toBe($this->profile)
        ->isLazy()->toBeTrue();
});

it('can be defer', function () {
    expect($this->profile)
        ->isDefer()->toBeFalse()
        ->defer()->toBe($this->profile)
        ->isDefer()->toBeTrue();
});