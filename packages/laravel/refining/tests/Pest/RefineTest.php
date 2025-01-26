<?php

declare(strict_types=1);

use Honed\Refining\Filters\BooleanFilter;
use Honed\Refining\Filters\DateFilter;
use Honed\Refining\Filters\Filter;
use Honed\Refining\Refine;
use Honed\Refining\Sorts\Sort;
use Honed\Refining\Tests\Stubs\Product;
use Honed\Refining\Tests\Stubs\Status;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

beforeEach(function () {
    $this->builder = Product::query();

    $this->refiners = [
        Filter::make('name')->like(),
        Filter::make('price', 'Minimum price')->gt(),
        // SetFilter::make('price', 'Maximum price')->options(10, 20, 50, 100)->lt(),
        // SetFilter::make('status')->enum(Status::class)->multiple()->strict(),
        // SetFilter::make('status', 'Single')->alias('only')->enum(Status::class),
        BooleanFilter::make('best_seller', 'Favourite')->alias('favourite'),
        DateFilter::make('created_at', 'Oldest')->alias('oldest')->gt(),
        DateFilter::make('created_at', 'Newest')->alias('newest')->lt(),

        Sort::make('name', 'A-Z')->alias('name-desc')->desc()->default(),
        Sort::make('name', 'Z-A')->alias('name-asc')->asc(),
        Sort::make('price'),
        Sort::make('best_seller', 'Favourite')->alias('favourite'),

        // Search::make('name'),
        // Search::make('description'),
    ];
});

it('requires refiners to be set', function () {
    expect(Refine::model(Product::class)->with($this->refiners)->getQuery())
        ->wheres->scoped(fn ($wheres) => $wheres
        ->toBeArray()
        ->toBeEmpty()
        )->orders->scoped(fn ($orders) => $orders
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($order) => $order
        ->toBeArray()
        ->{'column'}->toBe(Product::query()->qualifyColumn('name'))
        ->{'direction'}->toBe('desc')
        )
        );
});

it('requires a parameterised request', function () {
    $request = Request::create('/', 'GET');

    expect(Refine::model(Product::class)->with($this->refiners)->for($request)->getQuery())
        ->wheres->scoped(fn ($wheres) => $wheres
        ->toBeArray()
        ->toBeEmpty()
        )->orders->scoped(fn ($orders) => $orders // The default should be used
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($order) => $order
        ->{'column'}->toBe(Product::query()->qualifyColumn('name'))
        ->{'direction'}->toBe('desc')
        )
        );
});

it('can apply a filter', function () {
    $request = Request::create('/', 'GET', ['price' => 100]);

    expect(Refine::model(Product::class)->with($this->refiners)->for($request)->getQuery())
        ->wheres->scoped(fn ($wheres) => $wheres
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($filter) => $filter
        ->toBeArray()
        ->{'type'}->toBe('Basic')
        ->{'column'}->toBe($this->builder->qualifyColumn('price'))
        ->{'operator'}->toBe(Filter::GreaterThan)
        ->{'value'}->toBe(100)
        ->{'boolean'}->toBe('and')
        )
        )->orders->scoped(fn ($orders) => $orders
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($order) => $order
        ->toBeArray()
        ->{'column'}->toBe($this->builder->qualifyColumn('name'))
        ->{'direction'}->toBe('desc')
        )
        );
});

it('can apply a sort', function () {
    $request = Request::create('/', 'GET', ['sort' => '-name-asc']);

    expect(Refine::model(Product::class)->with($this->refiners)->for($request)->getQuery())
        ->wheres->scoped(fn ($wheres) => $wheres
        ->toBeArray()
        ->toBeEmpty()
        )->orders->scoped(fn ($orders) => $orders
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($order) => $order
        ->toBeArray()
        ->{'column'}->toBe($this->builder->qualifyColumn('name'))
        ->{'direction'}->toBe('asc')
        )
        );
});

it('can apply a search', function () {})->todo();

it('can search only selected columns', function () {})->todo();

it('can apply multiple refiners', function () {
    $request = Request::create('/', 'GET', ['favourite' => '1', 'status' => 'active', 'sort' => '-price']);

    expect(Refine::model(Product::class)->with($this->refiners)->for($request)->getQuery())
        ->wheres->scoped(fn ($wheres) => $wheres
        ->toBeArray()
        ->toHaveCount(1)
        )->orders->scoped(fn ($orders) => $orders
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($order) => $order
        ->toBeArray()
        ->{'column'}->toBe($this->builder->qualifyColumn('price'))
        ->{'direction'}->toBe('desc')
        )
        );
});

it('can refine a query', function () {
    $request = Request::create('/', 'GET', ['favourite' => '1', 'status' => 'active', 'sort' => '-price']);

    expect(Refine::query(Product::query()
        ->where('description', 'like', '%test%')
    )->with($this->refiners)->for($request)->getQuery())
        ->wheres->scoped(fn ($wheres) => $wheres
        ->toBeArray()
        ->toHaveCount(2)
        );
});

it('throws exception when no builder is set', function () {
    Refine::make('non-existent-class')->with($this->refiners)->getQuery();
})->throws(\InvalidArgumentException::class);

it('has array representation', function () {
    expect(Refine::make(Product::class)->with($this->refiners)->toArray())
        ->toBeArray()
        ->toHaveKeys(['sorts', 'filters', 'searches']);

    expect(Refine::make(Product::class)->with($this->refiners)->refinements())
        ->toBeArray()
        ->toHaveKeys(['sorts', 'filters', 'searches']);
});

it('only refines once', function () {
    $refine = Refine::make(Product::class)->with($this->refiners);

    expect($refine->get())->toBeInstanceOf(Collection::class);
    expect($refine->paginate())->toBeInstanceOf(LengthAwarePaginator::class);
});

it('has magic methods', function () {
    expect(Refine::make(Product::class))
        ->addSorts([Sort::make('name', 'A-Z')])->toBeInstanceOf(Refine::class)
        ->getSorts()->toHaveCount(1);

    expect(Refine::make(Product::class))
        ->addFilters([Filter::make('name', 'Name')->like()])->toBeInstanceOf(Refine::class)
        ->getFilters()->toHaveCount(1);
});

it('can change the sort key', function () {
    expect(Refine::make(Product::class))
        ->sortKey('name')->toBeInstanceOf(Refine::class)
        ->getSortKey()->toBe('name');
});

it('can change the search key', function () {
    expect(Refine::make(Product::class))
        ->searchKey('name')->toBeInstanceOf(Refine::class)
        ->getSearchKey()->toBe('name');
});
