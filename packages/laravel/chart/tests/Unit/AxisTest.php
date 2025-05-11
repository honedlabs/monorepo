<?php

declare(strict_types=1);

use Honed\Chart\Axis;
use Honed\Chart\Exceptions\InvalidAxisException;

beforeEach(function () {
    Axis::flushState();
});

it('has type', function () {
    expect(Axis::make())
        ->type('x')->toBeInstanceOf(Axis::class)
        ->getType()->toBe('x')
        ->for('y')->toBeInstanceOf(Axis::class)
        ->getType()->toBe('y')
        ->x()->toBeInstanceOf(Axis::class)
        ->getType()->toBe('x')
        ->y()->toBeInstanceOf(Axis::class)
        ->getType()->toBe('y');
});

it('validates type', function () {
    expect(fn () => Axis::make()->type('z'))
        ->toThrow(InvalidAxisException::class);
});

it('is full size', function () {
    expect(Axis::make())
        ->isFullSize()->toBeNull()
        ->fullSize()->toBeInstanceOf(Axis::class)
        ->isFullSize()->toBeTrue();
});

it('has grid', function () {
    expect(Axis::make())
        ->showsGrid()->toBeNull()
        ->grid()->toBeInstanceOf(Axis::class)
        ->showsGrid()->toBeTrue()
        ->showGrid(false)->toBeInstanceOf(Axis::class)
        ->showsGrid()->toBeFalse();
});

it('has grid with global default', function () {
    Axis::shouldShowGrid();

    expect(Axis::make())
        ->showsGrid()->toBeTrue();
});

it('has domain', function () {
    expect(Axis::make())
        ->showsDomain()->toBeNull()
        ->domain()->toBeInstanceOf(Axis::class)
        ->showsDomain()->toBeTrue()
        ->showDomain(false)->toBeInstanceOf(Axis::class)
        ->showsDomain()->toBeFalse();
});

it('has domain with global default', function () {
    Axis::shouldShowDomain();

    expect(Axis::make())
        ->showsDomain()->toBeTrue();
});

it('has array representation', function () {
    expect(Axis::make()->toArray())
        ->toBeArray()
        ->toBeEmpty();
});

it('has JSON representation', function () {
    $axis = Axis::make()->x();

    expect($axis->jsonSerialize())
        ->toEqual($axis->toArray());
});