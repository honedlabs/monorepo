<?php

declare(strict_types=1);

use Honed\Refine\Pipelines\RefineSearches;
use Honed\Refine\Refine;
use Honed\Refine\Searches\Search;
use Illuminate\Http\Request;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->builder = Product::query();

    $this->query = 'search+value';

    $this->term = 'search value';

    $searches = [
        Search::make('name'),
        Search::make('description'),
    ];

    $this->refine = Refine::make($this->builder)->searches($searches);
});

it('does not search if key is not present', function () {
    $request = Request::create('/', 'GET', [
        'search' => $this->query,
    ]);

    $this->refine->request($request);

    $this->refine->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeEmpty();

    expect($this->refine->getTerm())
        ->toBeNull();
});

it('searches if key is present', function () {
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

it('matches columns to search against', function () {

})->todo();

it('does not search if not searchable', function () {
    $request = Request::create('/', 'GET', [
        $this->refine->getSearchKey() => $this->query,
    ]);

    $this->refine->request($request)->notSearchable()->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeEmpty();

    expect($this->refine->getTerm())
        ->toBe('search value');
});

it('refines with match', function () {
    $request = Request::create('/', 'GET', [
        'search' => 'search+value',
        'match' => 'name',
    ]);

    $this->refine->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeOnlySearch('name');

    expect($this->refine->getTerm())
        ->toBe('search value');
});

it('does not search if scope does not match', function () {

});

describe('scope', function () {
    beforeEach(function () {
        $this->refine = $this->refine->scope('scope');
    });

    it('does not refine', function () {
        $request = Request::create('/', 'GET', [
            'search' => 'search+value',
            'match' => 'description',
        ]);

        $this->refine->request($request);

        $this->refine->refine();

        expect($this->refine->getBuilder()->getQuery()->wheres)
            ->toBeEmpty();

        expect($this->refine->getTerm())
            ->toBeNull();
    });

    it('refines', function () {
        $request = Request::create('/', 'GET', [
            $this->refine->formatScope('search') => 'search+value',
            $this->refine->formatScope('match') => 'description',
        ]);

        $this->refine->request($request);

        $this->refine->refine();

        expect($this->refine->getBuilder()->getQuery()->wheres)
            ->toBeOnlySearch('description');

        expect($this->refine->getTerm())
            ->toBe('search value');
    });
});
