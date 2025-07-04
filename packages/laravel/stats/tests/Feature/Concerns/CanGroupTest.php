<?php

declare(strict_types=1);

use Honed\Stats\Profile;

beforeEach(function () {
    $this->profile = Profile::make();
});

it('groups', function () {
    expect($this->profile)
        ->isGrouped()->toBeFalse()
        ->group()->toBe($this->profile)
        ->isGrouped()->toBeTrue()
        ->group('test')->toBe($this->profile)
        ->isGrouped()->toBeTrue();
});

it('does not group', function () {
    expect($this->profile)
        ->isNotGrouped()->toBeTrue()
        ->group('test')->toBe($this->profile)
        ->isNotGrouped()->toBeFalse()
        ->dontGroup()->toBe($this->profile)
        ->isNotGrouped()->toBeTrue();
});