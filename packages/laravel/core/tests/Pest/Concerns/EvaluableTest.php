<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Tests\Stubs\Product;

class EvaluableComponent
{
    use Evaluable;
}

beforeEach(function () {
    $this->component = new EvaluableComponent;
});

it('evaluates a closure', function () {
    expect($this->component->evaluate(fn () => 'value'))->toBe('value');
});

it('evaluates a primitive', function () {
    expect($this->component->evaluate(1))->toBe(1);
    expect($this->component->evaluate('value'))->toBe('value');
});

it('evaluates named parameters', function () {
    $fn = fn (int $id, string $prefix) => $prefix.$id;
    expect($this->component->evaluate($fn, ['id' => 1, 'prefix' => 'value']))->toBe('value1');
});

it('evaluates class-typed parameters', function () {
    $product = product();
    $fn = fn (Product $product) => $product->name;
    expect($this->component->evaluate($fn, [], [Product::class => $product]))
        ->toBe($product->name);
});

it('evaluates invokable objects', function () {
    $invokable = new class
    {
        public function __invoke()
        {
            return 'invoked';
        }
    };

    expect($this->component->evaluate($invokable))->toBe('invoked');
});

it('resolves default parameter values', function () {
    $fn = fn (string $name = 'default') => $name;
    expect($this->component->evaluate($fn))->toBe('default');
});