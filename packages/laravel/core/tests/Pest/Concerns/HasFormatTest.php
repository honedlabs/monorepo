<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasFormat;
use Honed\Core\Tests\Stubs\Product;

class FormatTest
{
    use Evaluable;
    use HasFormat;
}

beforeEach(function () {
    $this->test = new FormatTest;
});

it('sets', function () {
    expect($this->test->format('test'))
        ->toBeInstanceOf(FormatTest::class)
        ->hasFormat()->toBeTrue();
});

it('gets', function () {
    expect($this->test->format('test'))
        ->getFormat()->toBe('test')
        ->hasFormat()->toBeTrue();
});

it('evaluates', function () {
    $product = product();

    expect($this->test->format(fn (Product $product) => $product->name))
        ->getFormat(['product' => $product])->toBe($product->name)
        ->hasFormat()->toBeTrue();
});

it('evaluates model', function () {
    $product = product();
    expect($this->test->format(fn (Product $product) => $product->name))
        ->getFormat($product)->toBe($product->name)
        ->hasFormat()->toBeTrue();
});
