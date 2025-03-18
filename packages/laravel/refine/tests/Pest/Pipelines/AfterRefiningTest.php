<?php

declare(strict_types=1);

use Honed\Refine\Tests\Stubs\Product;
use Honed\Refine\Pipelines\AfterRefining;
use Honed\Refine\Tests\Fixtures\AfterRefiningFixture;
use Honed\Refine\Refine;

beforeEach(function () {
    $this->builder = Product::query();
    $this->refine = Refine::make($this->builder);
    $this->closure = fn ($refine) => $refine;
});

it('does not refine after', function () {
    $pipeline = new AfterRefining();

    $pipeline($this->refine, $this->closure);

    expect($this->refine->getFor()->getQuery()->wheres)
        ->toBeEmpty();
});

it('refines after using property', function () {
    $pipeline = new AfterRefining();

    $refine = $this->refine->after(fn ($builder) => $builder->where('price', '>', 100));

    $pipeline($refine, $this->closure);

    expect($refine->getFor()->getQuery()->wheres)
        ->toBeOnlyWhere('price', 100, '>', 'and');
});

it('refines after using method', function () {
    $refine = AfterRefiningFixture::make()
        ->for($this->builder);

    $pipeline = new AfterRefining();

    $pipeline($refine, $this->closure);

    expect($refine->getFor()->getQuery()->wheres)
        ->toBeOnlyWhere('price', 100, '>', 'and');
});
