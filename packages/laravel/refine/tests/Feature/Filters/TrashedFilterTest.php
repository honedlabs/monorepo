<?php

declare(strict_types=1);

use Honed\Refine\Filters\TrashedFilter;
use Honed\Refine\Option;
use Illuminate\Support\Facades\Request;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->filter = TrashedFilter::new();
});

it('has trashed filter', function () {
    expect($this->filter)
        ->toBe($this->filter)
        ->type()->toBe('trashed')
        ->getLabel()->toBe('Show deleted');
});

it('has options', function () {
    expect($this->filter)
        ->getOptions()->scoped(fn ($options) => $options
        ->toBeArray()
        ->toHaveCount(3)
        ->sequence(
            fn ($option) => $option
                ->toBeInstanceOf(Option::class)
                ->getValue()->toBe('with')
                ->getLabel()->toBe('With deleted'),
            fn ($option) => $option
                ->toBeInstanceOf(Option::class)
                ->getValue()->toBe('only')
                ->getLabel()->toBe('Only deleted'),
            fn ($option) => $option
                ->toBeInstanceOf(Option::class)
                ->getValue()->toBe('without')
                ->getLabel()->toBe('Without deleted')
        )
        );
});

it('applies with trashed', function () {
    $builder = Product::query();

    expect($this->filter)
        ->handle($builder, 'with')->toBeTrue();

    expect($builder->getQuery()->wheres)
        ->toBeEmpty();
});

it('applies only trashed', function () {
    $builder = Product::query();

    expect($this->filter)
        ->handle($builder, 'only')->toBeTrue();

    expect($builder->getQuery()->wheres)
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->toEqual([
            'type' => 'NotNull',
            'column' => $builder->qualifyColumn('deleted_at'),
            'boolean' => true,
        ]);
});

it('applies without trashed', function () {
    $builder = Product::query();

    expect($this->filter)
        ->handle($builder, 'without')->toBeTrue();

    expect($builder->getQuery()->wheres)
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->toEqual([
            'type' => 'Null',
            'column' => $builder->qualifyColumn('deleted_at'),
            'boolean' => 'and',
        ]);
});
