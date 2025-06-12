<?php

declare(strict_types=1);

use Honed\Refine\Filters\Filter;

beforeEach(function () {
    $this->filter = Filter::make('name');
});

it('can be hidden', function () {
    expect($this->filter)
        ->hidden()->toBe($this->filter)
        ->isHidden()->toBeTrue()
        ->isNotHidden()->toBeFalse()
        ->notHidden()->toBe($this->filter)
        ->isHidden()->toBeFalse()
        ->isNotHidden()->toBeTrue();
});

it('can be visible', function () {
    expect($this->filter)
        ->visible()->toBe($this->filter)
        ->isVisible()->toBeTrue()
        ->isNotVisible()->toBeFalse()
        ->notVisible()->toBe($this->filter)
        ->isVisible()->toBeFalse()
        ->isNotVisible()->toBeTrue();
});
