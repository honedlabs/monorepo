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

it('is null by default', function () {
    expect($this->test)
        ->name()->toBeNull()
        ->hasName()->toBeFalse();
});

it('sets', function () {
    expect($this->test->name('test'))
        ->toBeInstanceOf(NameTest::class)
        ->name()->toBe('test')
        ->hasName()->toBeTrue();
});

it('gets', function () {
    expect($this->test->name('test'))
        ->name()->toBe('test')
        ->hasName()->toBeTrue();
});

it('evaluates', function () {
    $product = product();
    expect($this->test->name(fn (Product $product) => $product->name))
        ->evaluateName(['product' => $product])->toBe($product->name)
        ->hasName()->toBeTrue();
});

it('evaluates model', function () {
    $product = product();
    expect($this->test->name(fn (Product $product) => $product->name))
        ->evaluateName($product)->toBe($product->name)
        ->hasName()->toBeTrue();
});

it('makes name', function () {
    expect($this->test->makeName('Title Case'))->toBe('title_case');
});
