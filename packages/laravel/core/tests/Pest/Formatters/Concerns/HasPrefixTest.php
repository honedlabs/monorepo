<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Formatters\Concerns\HasPrefix;
use Honed\Core\Tests\Stubs\Product;

class HasPrefixComponent
{
    use HasPrefix;
    use Evaluable;
}

beforeEach(function () {
    $this->component = new HasPrefixComponent;
});

it('has no prefix by default', function () {
    expect($this->component)
        ->getPrefix()->toBeNull()
        ->hasPrefix()->toBeFalse();
});

it('sets prefix', function () {
    $this->component->setPrefix('Prefix');
    expect($this->component)
        ->getPrefix()->toBe('Prefix')
        ->hasPrefix()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setPrefix('Prefix');
    $this->component->setPrefix(null);
    expect($this->component)
        ->getPrefix()->toBe('Prefix')
        ->hasPrefix()->toBeTrue();
});

it('chains prefix', function () {
    expect($this->component->prefix('Prefix'))->toBeInstanceOf(HasPrefixComponent::class)
        ->getPrefix()->toBe('Prefix')
        ->hasPrefix()->toBeTrue();
});

it('resolves prefix', function () {
    $this->component->prefix(fn (Product $product) => $product->name);
    $product = product();

    expect($this->component)
        ->resolvePrefix([], [Product::class => $product])->toBe($product->name)
        ->getPrefix()->toBe($product->name)
        ->hasPrefix()->toBeTrue();
});
