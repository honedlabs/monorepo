<?php

declare(strict_types=1);

use Honed\Refine\Sorts\Sort;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->builder = Product::query();
    $this->sort = Sort::make('name');
});

it('has direction', function () {
    expect($this->sort)
        ->getDirection()->toBeNull()
        ->direction('asc')->toBe($this->sort)
        ->getDirection()->toBe('asc');
});

it('can be ascending', function () {
    expect($this->sort)
        ->isAscending()->toBeFalse()
        ->ascending()->toBe($this->sort)
        ->isAscending()->toBeTrue()
        ->asc()->toBe($this->sort)
        ->isAscending()->toBeTrue();
});

it('can be descending', function () {
    expect($this->sort)
        ->isDescending()->toBeFalse()
        ->descending()->toBe($this->sort)
        ->isDescending()->toBeTrue()
        ->desc()->toBe($this->sort)
        ->isDescending()->toBeTrue();
});

it('can invert', function () {
    expect($this->sort)
        ->isInverted()->toBeFalse()
        ->invert()->toBe($this->sort)
        ->isInverted()->toBeTrue();
});

it('can set fixed direction', function () {
    expect($this->sort)
        ->enforcesDirection()->toBeFalse()
        ->fixed('asc')->toBe($this->sort)
        ->enforcesDirection()->toBeTrue()
        ->getDirection()->toBe('asc');
});
