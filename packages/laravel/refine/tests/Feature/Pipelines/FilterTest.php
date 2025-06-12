<?php

declare(strict_types=1);

use Honed\Refine\Filters\Filter;
use Honed\Refine\Refine;
use Illuminate\Support\Facades\Request;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->name = 'price';

    $this->value = 100;

    $this->refine = Refine::make(User::class)
        ->filters(Filter::make($this->name)->int());
});

it('does not filter if key is not present', function () {
    $request = Request::create('/', 'GET', [
        'invalid' => $this->value,
    ]);

    $this->refine->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeEmpty();
});

it('filters with key', function () {
    $request = Request::create('/', 'GET', [
        $this->name => $this->value,
    ]);

    $this->refine->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeOnlyWhere($this->name, $this->value);
});

it('filters with default', function () {
    $name = 'name';
    $value = 'joshua';

    $request = Request::create('/', 'GET');

    $this->refine->filters([
        Filter::make($name)
            ->default($value),
    ])
        ->request($request)
        ->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeOnlyWhere($name, $value);
})->todo();

it('can disable filtering', function () {
    $request = Request::create('/', 'GET', [
        $this->name => $this->value,
    ]);

    $this->refine->request($request)->notFilterable()->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeEmpty();
});

it('does not filter if scoped parameter is not present', function () {
    $request = Request::create('/', 'GET', [
        $this->name => $this->value,
    ]);

    $this->refine->scope('scope')->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->orders)
        ->toBeEmpty();
});

it('sorts with scoped key', function () {
    $this->refine->scope('scope');

    $request = Request::create('/', 'GET', [
        $this->refine->formatScope($this->name) => $this->value,
    ]);

    $this->refine->request($request)->refine();

    expect($this->refine->getBuilder()->getQuery()->wheres)
        ->toBeOnlyWhere($this->name, $this->value);
});
