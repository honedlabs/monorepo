<?php

declare(strict_types=1);

use Honed\Refine\Tests\Stubs\Product;
use Honed\Refine\Pipelines\BeforeRefining;
use Honed\Refine\Tests\Fixtures\BeforeRefiningFixture;
use Honed\Refine\Refine;

beforeEach(function () {
    $this->builder = Product::query();
    $this->refine = Refine::make($this->builder);
    $this->closure = fn ($refine) => $refine;
    $this->fn = fn ($builder) => $builder->where('price', '>', 100);
});

it('does not refine before', function () {
    $pipeline = new BeforeRefining();

    $pipeline($this->refine, $this->closure);

    expect($this->refine->getFor()->getQuery()->wheres)
        ->toBeEmpty();
});

it('refines before using property', function () {
    $pipeline = new BeforeRefining();

    $refine = $this->refine
        ->before($this->fn);

    $pipeline($refine, $this->closure);

    expect($refine->getFor()->getQuery()->wheres)
        ->toBeOnlyWhere('price', 100, '>', 'and');
});

it('refines before using method', function () {
    $refine = BeforeRefiningFixture::make()
        ->for($this->builder);

    $pipeline = new BeforeRefining();

    $pipeline($refine, $this->closure);

    expect($refine->getFor()->getQuery()->wheres)
        ->toBeOnlyWhere('price', 100, '>', 'and');
});