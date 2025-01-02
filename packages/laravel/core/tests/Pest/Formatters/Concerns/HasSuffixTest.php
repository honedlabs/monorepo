<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Formatters\Concerns\HasSuffix;
use Honed\Core\Tests\Stubs\Product;

class HasSuffixComponent
{
    use HasSuffix;
    use Evaluable;
}

beforeEach(function () {
    $this->component = new HasSuffixComponent;
});

it('has no suffix by default', function () {
    expect($this->component)
        ->getSuffix()->toBeNull()
        ->hasSuffix()->toBeFalse();
});

it('sets suffix', function () {
    $this->component->setSuffix('Suffix');
    expect($this->component)
        ->getSuffix()->toBe('Suffix')
        ->hasSuffix()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setSuffix('Suffix');
    $this->component->setSuffix(null);
    expect($this->component)
        ->getSuffix()->toBe('Suffix')
        ->hasSuffix()->toBeTrue();
});

it('chains suffix', function () {
    expect($this->component->suffix('Suffix'))->toBeInstanceOf(HasSuffixComponent::class)
        ->getSuffix()->toBe('Suffix')
        ->hasSuffix()->toBeTrue();
});

it('resolves suffix', function () {
    $this->component->suffix(fn (Product $product) => $product->name);
    $product = product();

    expect($this->component)
        ->resolveSuffix([], [Product::class => $product])->toBe($product->name)
        ->getSuffix()->toBe($product->name)
        ->hasSuffix()->toBeTrue();
});
