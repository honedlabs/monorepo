<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasTitle;
use Honed\Core\Tests\Stubs\Product;

class TitleTest
{
    use Evaluable;
    use HasTitle;
}

beforeEach(function () {
    $this->test = new TitleTest;
});

it('is null by default', function () {
    expect($this->test)
        ->title()->toBeNull()
        ->hasTitle()->toBeFalse();
});

it('sets', function () {
    expect($this->test->title('test'))
        ->toBeInstanceOf(TitleTest::class)
        ->title()->toBe('test')
        ->hasTitle()->toBeTrue();
});

it('gets', function () {
    expect($this->test->title('test'))
        ->title()->toBe('test')
        ->hasTitle()->toBeTrue();
});

it('evaluates', function () {
    $product = product();
    expect($this->test->title(fn (Product $product) => $product->name))
        ->evaluateTitle(['product' => $product])->toBe($product->name)
        ->hasTitle()->toBeTrue();
});

it('evaluates model', function () {
    $product = product();
    expect($this->test->title(fn (Product $product) => $product->name))
        ->evaluateTitle($product)->toBe($product->name)
        ->hasTitle()->toBeTrue();
});