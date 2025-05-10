<?php

declare(strict_types=1);

use Honed\Chart\CrossHair;

beforeEach(function () {
    CrossHair::flushState();
});

it('hides', function () {
    expect(CrossHair::make())
        ->hides()->toBeNull()
        ->hide()->toBeInstanceOf(CrossHair::class)
        ->hides()->toBeTrue();
});

it('hides with global default', function () {
    CrossHair::shouldHide();

    expect(CrossHair::make())
        ->hides()->toBeTrue();
});

it('hides at a distance', function () {
    expect(CrossHair::make())
        ->getHideDistance()->toBeNull()
        ->hideAt(10)->toBeInstanceOf(CrossHair::class)
        ->getHideDistance()->toBe(10);
});

it('hides at a distance with global default', function () {
    CrossHair::useHideDistance(10);

    expect(CrossHair::make())
        ->getHideDistance()->toBe(10);
});

it('snaps', function () {
    expect(CrossHair::make())
        ->snaps()->toBeNull()
        ->snap()->toBeInstanceOf(CrossHair::class)
        ->snaps()->toBeTrue();
});

it('snaps with global default', function () {
    CrossHair::shouldSnap();

    expect(CrossHair::make())
        ->snaps()->toBeTrue();
});

it('has array representation', function () {
    expect(CrossHair::make()->toArray())
        ->toBeArray()
        ->toBeEmpty();
});

it('has JSON representation', function () {
    $crossHair = CrossHair::make();

    expect($crossHair->jsonSerialize())
        ->toEqual($crossHair->toArray());
});
