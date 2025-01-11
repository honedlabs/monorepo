<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasDescription;
use Honed\Core\Tests\Stubs\Product;

class DescriptionTest
{
    use Evaluable;
    use HasDescription;
}

beforeEach(function () {
    $this->test = new DescriptionTest;
});

it('sets', function () {
    expect($this->test->description('test'))
        ->toBeInstanceOf(DescriptionTest::class)
        ->hasDescription()->toBeTrue();
});

it('gets', function () {
    expect($this->test->description('test'))
        ->getDescription()->toBe('test')
        ->hasDescription()->toBeTrue();
});

it('evaluates', function () {
    $product = product();

    expect($this->test->description(fn (Product $product) => $product->name))
        ->getDescription(['product' => $product])->toBe($product->name)
        ->hasDescription()->toBeTrue();
});

it('evaluates model', function () {
    $product = product();
    expect($this->test->description(fn (Product $product) => $product->name))
        ->getDescription($product)->toBe($product->name)
        ->hasDescription()->toBeTrue();
});