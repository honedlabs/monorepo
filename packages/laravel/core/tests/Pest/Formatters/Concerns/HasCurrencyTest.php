<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Formatters\Concerns\HasCurrency;
use Honed\Core\Tests\Stubs\Product;

class HasCurrencyComponent
{
    use Evaluable;
    use HasCurrency;
}

beforeEach(function () {
    $this->component = new HasCurrencyComponent;
});

it('has no currency by default', function () {
    expect($this->component)
        ->getCurrency()->toBeNull()
        ->hasCurrency()->toBeFalse();
});

it('sets currency', function () {
    $this->component->setCurrency('Currency');
    expect($this->component)
        ->getCurrency()->toBe('Currency')
        ->hasCurrency()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setCurrency('Currency');
    $this->component->setCurrency(null);
    expect($this->component)
        ->getCurrency()->toBe('Currency')
        ->hasCurrency()->toBeTrue();
});

it('chains currency', function () {
    expect($this->component->currency('Currency'))->toBeInstanceOf(HasCurrencyComponent::class)
        ->getCurrency()->toBe('Currency')
        ->hasCurrency()->toBeTrue();
});

it('resolves currency', function () {
    $this->component->currency(fn (Product $product) => $product->name);
    $product = product();

    expect($this->component)
        ->resolveCurrency([], [Product::class => $product])->toBe($product->name)
        ->getCurrency()->toBe($product->name)
        ->hasCurrency()->toBeTrue();
});
