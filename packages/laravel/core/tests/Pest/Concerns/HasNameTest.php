<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasName;
use Honed\Core\Tests\Stubs\Product;

class NameTest
{
    use Evaluable;
    use HasName;
}

beforeEach(function () {
    $this->test = new NameTest;
});

it('sets', function () {
    expect($this->test->name('test'))
        ->toBeInstanceOf(NameTest::class)
        ->hasName()->toBeTrue();
});

it('gets', function () {
    expect($this->test->name('test'))
        ->getName()->toBe('test')
        ->hasName()->toBeTrue();
});

it('evaluates', function () {
    $product = product();

    expect($this->test->name(fn (Product $product) => $product->name))
        ->getName(['product' => $product])->toBe($product->name)
        ->hasName()->toBeTrue();
});

it('evaluates model', function () {
    $product = product();
    expect($this->test->name(fn (Product $product) => $product->name))
        ->getName($product)->toBe($product->name)
        ->hasName()->toBeTrue();
});

it('makes a name', function () {
    expect($this->test->makeName('New label'))->toBe('new_label');
});