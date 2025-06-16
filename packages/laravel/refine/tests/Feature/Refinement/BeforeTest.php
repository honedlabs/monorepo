<?php

declare(strict_types=1);

use Honed\Refine\Refine;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->refine = Refine::make(User::class);
});

it('does not refine before', function () {
    $this->refine->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeEmpty();
});

it('refines before using callback', function () {
    $this->refine->before(fn ($builder) => $builder->where('price', '>', 100));

    $this->refine->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeOnlyWhere('price', 100, '>', 'and');
});
