<?php

declare(strict_types=1);

use Honed\Refine\Pipelines\BeforeRefining;
use Workbench\App\Refiners\RefineProduct;
use Workbench\App\Refiners\RefineUser;

beforeEach(function () {
    $this->pipe = new BeforeRefining();
    $this->closure = fn ($refine) => $refine;
})->skip();

it('does not refine before', function () {
    $refiner = RefineProduct::make();

    ($this->pipe)($refiner, $this->closure);

    expect($refiner->getResource()->getQuery()->wheres)
        ->toBeEmpty();
});

it('refines before using property', function () {
    $refiner = RefineProduct::make();

    $refiner->before(fn ($builder) => $builder->where('price', '>', 100));

    ($this->pipe)($refiner, $this->closure);

    expect($refiner->getResource()->getQuery()->wheres)
        ->toBeOnlyWhere('price', 100, '>', 'and');
});

it('refines before using method', function () {
    $refiner = RefineUser::make();

    ($this->pipe)($refiner, $this->closure);

    expect($refiner->getResource()->getQuery()->wheres)
        ->toBeOnlyWhere('email', 'test@test.com', '=', 'and');
});
