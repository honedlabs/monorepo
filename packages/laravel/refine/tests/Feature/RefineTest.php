<?php

declare(strict_types=1);

use Honed\Refine\Filter;
use Honed\Refine\Refine;
use Honed\Refine\Search;
use Honed\Refine\Sort;
use Illuminate\Auth\Access\Gate as AccessGate;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Workbench\App\Models\Product;

beforeEach(function () {
    $this->test = Refine::make(Product::class);
});

it('goes without refining', function () {
    expect($this->test)
        ->searchingEnabled()->toBeTrue()
        ->filteringEnabled()->toBeTrue()
        ->sortingEnabled()->toBeTrue();
});

it('refines before', function () {
    expect($this->test)
        ->before(fn () => $this->test)->toBe($this->test);
});

it('refines after', function () {
    expect($this->test)
        ->after(fn () => $this->test)->toBe($this->test);
});

it('evaluates named closure dependencies', function () {
    $product = Product::factory()->create();
    $request = FacadesRequest::create(route('products.show', $product), 'GET', ['key' => 'value']);

    expect($this->test->request($request)->withResource(Product::query()))
        ->evaluate(fn ($request) => $request->get('key'))->toBe('value')
        // ->evaluate(fn ($route) => $route)->toBeInstanceOf(Route::class)
        ->evaluate(fn ($builder) => $builder->getModel())->toBeInstanceOf(Product::class)
        ->evaluate(fn ($query) => $query->getModel())->toBeInstanceOf(Product::class)
        ->evaluate(fn ($product) => $product->getModel())->toBeInstanceOf(Product::class)
        ->evaluate(fn ($products) => $products->getModel())->toBeInstanceOf(Product::class);
});

it('evaluates typed closure dependencies', function () {
    $product = Product::factory()->create();
    $request = FacadesRequest::create(route('products.show', $product), 'GET', ['key' => 'value']);

    expect($this->test->request($request)->withResource(Product::query()))
        ->evaluate(fn (Request $r) => $r->get('key'))->toBe('value')
        ->evaluate(fn (Builder $b) => $b->getModel())->toBeInstanceOf(Product::class)
        // ->evaluate(fn (Route $r) => $r)->toBeInstanceOf(Route::class)
        ->evaluate(fn (Gate $g) => $g)->toBeInstanceOf(AccessGate::class);
});

it('forwards calls to the builder', function () {
    expect($this->test)
        ->paginate(10)->toBeInstanceOf(LengthAwarePaginator::class)
        ->isRefined()->toBeTrue();
});

it('has macro', function () {
    $this->test->macro('test', fn () => 'test');

    expect($this->test)
        ->test()->toBe('test');
});

it('has array representation', function () {
    $this->test->with([
        Filter::make('name'),
        Sort::make('name'),
        Search::make('name'),
        Product::factory()->create(), // Misc class
    ]);

    expect($this->test->toArray())->toBeArray()
        ->toHaveCount(4)
        ->toHaveKeys(['filters', 'sorts', 'searches', 'config'])
        ->{'config'}->scoped(fn ($config) => $config
        ->{'delimiter'}->toBe(',')
        ->{'term'}->toBeNull()
        ->{'search'}->toBe(config('refine.search_key'))
        ->{'sort'}->toBe(config('refine.sort_key'))
            // ->{'match'}->toBe(config('refine.match_key'))
        );
});

it('has array representation with matches', function () {
    $this->test->with([
        Filter::make('name'),
        Sort::make('name'),
        Search::make('name'),
    ])->matches();

    expect($this->test->toArray())->toBeArray()
        ->toHaveCount(4)
        ->toHaveKeys(['filters', 'sorts', 'searches', 'config'])
        ->{'config'}->toEqual([
            'delimiter' => ',',
            'term' => null,
            'search' => config('refine.search_key'),
            'sort' => config('refine.sort_key'),
            'match' => config('refine.match_key'),
        ]);
});

it('has array representation with scopes', function () {
    $this->test->scope('name', 'John')->matches();

    expect($this->test->toArray())->toBeArray()
        ->{'config'}->toEqual([
            'delimiter' => ',',
            'term' => null,
            'search' => $this->test->formatScope(config('refine.search_key')),
            'sort' => $this->test->formatScope(config('refine.sort_key')),
            'match' => $this->test->formatScope(config('refine.match_key')),
        ]);
});

it('refines once', function () {
    expect($this->test)
        ->refine()->toBe($this->test)
        ->isRefined()->toBeTrue()
        ->refine()->toBe($this->test)
        ->isRefined()->toBeTrue();
});
