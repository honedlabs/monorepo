<?php

declare(strict_types=1);

use Honed\Refine\Refine;
use Honed\Refine\Searches\Search;
use Illuminate\Http\Request;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->query = 'search+value';

    $this->term = 'search value';

    $searches = [
        Search::make('name'),
        Search::make('description'),
    ];

    $this->refine = Refine::make(Product::class)->searches($searches);
});

it('does not search if key is not present', function () {
    $request = Request::create('/', 'GET', [
        'invalid' => $this->query,
    ]);

    $this->refine->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeEmpty();

    expect($this->refine->getTerm())
        ->toBeNull();
});

it('searches with key', function () {
    $request = Request::create('/', 'GET', [
        $this->refine->getSearchKey() => $this->query,
    ]);

    $this->refine->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->{0}->toBeSearch('name', 'and')
        ->{1}->toBeSearch('description', 'or');

    expect($this->refine->getTerm())
        ->toBe($this->term);
});

it('does not match columns to search against if not matchable', function () {
    $request = Request::create('/', 'GET', [
        $this->refine->getSearchKey() => $this->query,
        $this->refine->getMatchKey() => 'name',
    ]);

    $this->refine->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->{0}->toBeSearch('name', 'and')
        ->{1}->toBeSearch('description', 'or');

    expect($this->refine->getTerm())
        ->toBe($this->term);
});

it('matches columns to search against', function () {
    $request = Request::create('/', 'GET', [
        $this->refine->getSearchKey() => $this->query,
        $this->refine->getMatchKey() => 'name',
    ]);

    $this->refine->request($request)->matchable()->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeOnlySearch('name');

    expect($this->refine->getTerm())
        ->toBe($this->term);
});

it('can disable searching', function () {
    $request = Request::create('/', 'GET', [
        $this->refine->getSearchKey() => $this->query,
    ]);

    $this->refine->request($request)->notSearchable()->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeEmpty();

    expect($this->refine->getTerm())
        ->toBe($this->term);
});

it('does not search if scoped key is not present', function () {
    $request = Request::create('/', 'GET', [
        $this->refine->getSearchKey() => $this->query,
        $this->refine->getMatchKey() => 'name',
    ]);

    $this->refine->scope('scope')->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->orders)
        ->toBeEmpty();

    expect($this->refine->getTerm())
        ->toBeNull();
});

it('searches with scoped key', function () {
    $this->refine->scope('scope');

    $request = Request::create('/', 'GET', [
        $this->refine->getSearchKey() => $this->query,
        $this->refine->getMatchKey() => 'description',
    ]);

    $this->refine->request($request)->matchable()->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeOnlySearch('description');

    expect($this->refine->getTerm())
        ->toBe($this->term);
});
