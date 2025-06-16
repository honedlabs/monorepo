<?php

declare(strict_types=1);

use Honed\Refine\Refine;
use Honed\Refine\Sorts\Sort;
use Illuminate\Support\Facades\Request;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->name = 'name';

    $this->refine = Refine::make(User::class)
        ->sorts(Sort::make($this->name));
});

it('does not sort if parameter is not present', function () {
    $request = Request::create('/', 'GET', [
        $this->refine->getSortKey() => 'other',
    ]);

    $this->refine->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->orders)
        ->toBeEmpty();
});

it('sorts with key', function () {
    $request = Request::create('/', 'GET', [
        $this->refine->getSortKey() => $this->name,
    ]);

    $this->refine->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->orders)
        ->toBeOnlyOrder($this->name, Sort::ASCENDING);
});

it('sorts with default', function () {
    $name = 'price';

    $request = Request::create('/', 'GET', [
        $this->refine->getSortKey() => $name,
    ]);

    $this->refine->sorts(Sort::make($name)->default())
        ->request($request)
        ->refine();

    expect($this->refine->getBuilder()->getQuery()->orders)
        ->toBeOnlyOrder($name, Sort::ASCENDING);
});

it('sorts with direction', function () {
    $request = Request::create('/', 'GET', [
        $this->refine->getSortKey() => '-'.$this->name,
    ]);

    $this->refine->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->orders)
        ->toBeOnlyOrder($this->name, Sort::DESCENDING);
});

it('can disable sorting', function () {
    $request = Request::create('/', 'GET', [
        $this->refine->getSortKey() => $this->name,
    ]);

    $this->refine->request($request)->notSortable()->refine();

    expect($this->refine->getBuilder()->getQuery()->orders)
        ->toBeEmpty();
});

it('does not sort if scoped key is not present', function () {
    $request = Request::create('/', 'GET', [
        $this->refine->getSortKey() => $this->name,
    ]);

    $this->refine->scope('scope')->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->orders)
        ->toBeEmpty();
});

it('sorts with scoped key', function () {
    $this->refine->scope('scope');

    $request = Request::create('/', 'GET', [
        $this->refine->getSortKey() => $this->name,
    ]);

    $this->refine->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->orders)
        ->toBeOnlyOrder($this->name, Sort::ASCENDING);
});
