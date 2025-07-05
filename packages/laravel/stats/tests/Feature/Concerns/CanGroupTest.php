<?php

declare(strict_types=1);

use Honed\Stats\Overview;

beforeEach(function () {
    $this->overview = Overview::make();
});

it('groups', function () {
    expect($this->overview)
        ->isGrouped()->toBeFalse()
        ->group()->toBe($this->overview)
        ->isGrouped()->toBeTrue()
        ->group('test')->toBe($this->overview)
        ->isGrouped()->toBeTrue();
});

it('does not group', function () {
    expect($this->overview)
        ->isNotGrouped()->toBeTrue()
        ->group('test')->toBe($this->overview)
        ->isNotGrouped()->toBeFalse()
        ->dontGroup()->toBe($this->overview)
        ->isNotGrouped()->toBeTrue();
});