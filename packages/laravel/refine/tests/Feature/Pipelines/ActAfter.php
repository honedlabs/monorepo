<?php

declare(strict_types=1);

use Honed\Refine\Pipelines\AfterRefining;
use Workbench\App\Refiners\RefineProduct;
use Workbench\App\Refiners\RefineUser;

beforeEach(function () {
    $this->pipe = new AfterRefining();
    $this->closure = fn ($refine) => $refine;
})->skip();

it('does not refine after', function () {
    $refiner = RefineProduct::make();

    ($this->pipe)($refiner, $this->closure);

    expect($refiner->getResource()->getQuery()->wheres)
        ->toBeEmpty();
});

it('refines after using property', function () {
    $refiner = RefineProduct::make();

    $refiner->after(fn ($builder) => $builder->where('price', '>', 100));

    ($this->pipe)($refiner, $this->closure);

    expect($refiner->getResource()->getQuery()->wheres)
        ->toBeOnlyWhere('price', 100, '>', 'and');
});

it('refines after using method', function () {
    $refiner = RefineUser::make();

    ($this->pipe)($refiner, $this->closure);

    expect($refiner->getResource()->getQuery()->orders)
        ->toBeOnlyOrder('created_at', 'desc');
});
