<?php

declare(strict_types=1);

use Honed\Chart\Series\Line\Line;

// beforeEach(function () {
//     Line::flushState();
// });

it('interpolates', function () {
    expect(Line::make())
        ->interpolates()->toBeNull()
        ->interpolate()->toBeInstanceOf(Line::class)
        ->interpolates()->toBeTrue();
});

it('interpolates with global default', function () {
    Line::shouldInterpolate();

    expect(Line::make())
        ->hides()->toBeTrue();
});

it('has fallback', function () {
    expect(Line::make())
        ->getFallback()->toBeNull()
        ->fallback(0)->toBeInstanceOf(Line::class)
        ->getFallback()->toBe(0);
});

it('has fallback with global default', function () {
    Line::useFallback(0);

    expect(Line::make())
        ->getFallback()->toBe(0);
});

it('highlights', function () {
    expect(Line::make())
        ->highlights()->toBeNull()
        ->highlight()->toBeInstanceOf(Line::class)
        ->highlights()->toBeTrue();
});

it('highlights with global default', function () {
    Line::shouldHighlight();

    expect(Line::make())
        ->highlights()->toBeTrue();
});

it('has array representation', function () {
    expect(Line::make()->toArray())
        ->toBeArray()
        ->toBeEmpty();
});

it('has JSON representation', function () {
    $chart = Line::make();

    expect($chart->jsonSerialize())
        ->toEqual($chart->toArray());
});
