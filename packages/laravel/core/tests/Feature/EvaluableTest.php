<?php

use Honed\Core\Tests\Fixtures\Column;
use Honed\Core\Tests\Stubs\Product;
use Honed\Core\Tests\Stubs\Status;
use Illuminate\Contracts\Container\BindingResolutionException;

beforeEach(function () {
    $this->test = Column::make();
});

it('evaluates a closure', function () {
    expect($this->test)
        ->evaluate(fn () => 'value')->toBe('value');
});

it('evaluates non-closures', function () {
    expect($this->test)
        ->evaluate(1)->toBe(1)
        ->evaluate('value')->toBe('value');
});

it('evaluates named parameters', function () {
    $fn = fn (int $id, string $prefix) => $prefix.$id;
    expect($this->test)
        ->evaluate($fn, ['id' => 1, 'prefix' => 'value'])->toBe('value1');
});

it('evaluates class-typed parameters', function () {
    $product = product();
    $fn = fn (Product $product) => $product->name;
    expect($this->test)
        ->evaluate($fn, [], [Product::class => $product])->toBe($product->name);
});

it('evaluates invokable objects', function () {
    $invokable = new class
    {
        public function __invoke()
        {
            return 'invoked';
        }
    };

    expect($this->test)
        ->evaluate($invokable)->toBe('invoked');
});

it('resolves fallback parameter values', function () {
    $fn = fn (string $name = 'default') => $name;
    expect($this->test)
        ->evaluate($fn)->toBe('default')
        ->evaluate($fn, ['name' => 'value'])->toBe('value');
});

it('resolves default parameter values by type', function () {
    $product = product();
    $fn = fn (Product $p) => $p->description;

    expect($this->test)
        ->evaluate($fn)->toBe($product->description);
});

it('resolves default parameter values by name', function () {
    $product = product();
    $fn = fn ($product) => $product->description;

    expect($this->test)
        ->evaluate($fn)->toBe($product->description);
});

it('fails if it cannot find a binding', function () {
    $fn = fn (Status $status) => $status->label();

    $this->test->evaluate($fn);
})->throws(BindingResolutionException::class);
