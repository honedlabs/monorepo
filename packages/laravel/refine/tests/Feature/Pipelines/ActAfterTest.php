<?php

declare(strict_types=1);

use Honed\Refine\Pipelines\AfterRefining;
use Honed\Refine\Refine;
use Workbench\App\Models\User;
use Workbench\App\Refiners\RefineProduct;
use Workbench\App\Refiners\RefineUser;

beforeEach(function () {
    $this->refine = Refine::make(User::class);
});

it('does not refine after', function () {
    $this->refine->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeEmpty();
});

it('refines after using callback', function () {
    $this->refine->after(fn ($builder) => $builder->where('price', '>', 100));

    $this->refine->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeOnlyWhere('price', 100, '>', 'and');
});