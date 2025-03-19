<?php

declare(strict_types=1);

use Honed\Refine\Refine;
use Honed\Refine\Filter;
use Honed\Refine\Tests\Stubs\Product;

beforeEach(function () {
    $this->test = Refine::make(Product::class);
});

it('is empty by default', function () {
    expect($this->test)
        ->hasFilters()->toBeFalse()
        ->getFilters()->toBeEmpty();
});

it('adds filters', function () {
    expect($this->test)
        ->addFilters([Filter::make('name')])->toBe($this->test)
        ->addFilters([Filter::make('price')])->toBe($this->test)
        ->hasFilters()->toBeTrue()
        ->getFilters()->toHaveCount(2);
});

it('adds filters collection', function () {
    expect($this->test)
        ->addFilters(collect([Filter::make('name'), Filter::make('price')]))->toBe($this->test)
        ->hasFilters()->toBeTrue()
        ->getFilters()->toHaveCount(2);
});

it('adds filter', function () {
    expect($this->test)
        ->addFilter(Filter::make('name'))->toBe($this->test)
        ->hasFilters()->toBeTrue()
        ->getFilters()->toHaveCount(1);
});

it('is filtering', function () {
    expect($this->test)
        ->isFiltering()->toBeTrue()
        ->filtering(false)->toBe($this->test)
        ->isFiltering()->toBeFalse();
});

it('without filters', function () {
    expect($this->test)
        ->isWithoutFilters()->toBeFalse()
        ->withoutFilters()->toBe($this->test)
        ->isWithoutFilters()->toBeTrue();
});

it('filters to array', function () {
    expect($this->test)
        ->addFilters([Filter::make('name'), Filter::make('price')])->toBe($this->test)
        ->filtersToArray()->toHaveCount(2)
        ->each->scoped(fn ($filter) => $filter
            ->toHaveKeys([
                'name',
                'label',
                'type',
                'active',
                'meta',
                'value',
                'options',
                'multiple'
            ])
        );
});

it('hides filters from serialization', function () {
    expect($this->test)
        ->addFilters([Filter::make('name')])->toBe($this->test)
        ->filtersToArray()->toHaveCount(1)
        ->withoutFilters()->toBe($this->test)
        ->filtersToArray()->toBeEmpty();
});
