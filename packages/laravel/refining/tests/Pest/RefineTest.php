<?php

declare(strict_types=1);

use Honed\Refining\Refine;
use Honed\Refining\Sorts\Sort;
use Honed\Refining\Filters\Filter;
use Honed\Refining\Tests\Stubs\Status;
use Honed\Refining\Tests\Stubs\Product;

beforeEach(function () {
    $this->builder = Product::query();

    $this->refiners = [
        Filter::make('name')->like(),
        // Filter::make('price', 'Minimum price')->gt(),
        // SetFilter::make('price', 'Maximum price')->options(10, 20, 50, 100)->lt(),
        // SetFilter::make('status')->enum(Status::class)->multiple()->strict(),
        // SetFilter::make('status', 'Single')->alias('only')->enum(Status::class),
        // BooleanFilter::make('best_seller', 'Favourite')->alias('favourite'),
        // DateFilter::make('created_at', 'Oldest')->alias('oldest')->gt(),
        // DateFilter::make('created_at', 'Newest')->alias('newest')->lt(),
        
        Sort::make('name', 'A-Z')->alias('name-desc')->desc()->default(),
        Sort::make('name', 'Z-A')->alias('name-asc')->asc(),
        Sort::make('price'),
        Sort::make('best_seller', 'Favourite')->alias('favourite'),

        // Search::make('name'),
        // Search::make('description'),
    ];
});

it('tests', function () {
    // dd(
    //     Refine::model(Product::class)->get()
    // );

});
