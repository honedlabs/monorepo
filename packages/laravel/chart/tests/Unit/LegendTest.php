<?php

declare(strict_types=1);

use Honed\Chart\Legend;

beforeEach(function () {
    Legend::flushState();
});

it('has domain', function () {
    expect(Legend::make())
        ->showsDomain()->toBeNull()
        ->domain()->toBeInstanceOf(Legend::class)
        ->showsDomain()->toBeTrue()
        ->showDomain(false)->toBeInstanceOf(Legend::class)
        ->showsDomain()->toBeFalse();
});

it('has domain with global default', function () {
    Legend::shouldShowDomain();

    expect(Legend::make())
        ->showsDomain()->toBeTrue();
});

it('has array representation', function () {
    expect(Legend::make()->toArray())
        ->toBeArray()
        ->toBeEmpty();
});

it('has JSON representation', function () {
    $crossHair = Legend::make();

    expect($crossHair->jsonSerialize())
        ->toEqual($crossHair->toArray());
});
