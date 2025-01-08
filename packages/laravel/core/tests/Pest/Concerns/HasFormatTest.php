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

it('is null by default', function () {
    expect($this->test)
        ->format()->toBeNull()
        ->hasFormat()->toBeFalse();
});

it('sets', function () {
    expect($this->test->format('test'))
        ->toBeInstanceOf(FormatTest::class)
        ->format()->toBe('test')
        ->hasFormat()->toBeTrue();
});

it('gets', function () {
    expect($this->test->format('test'))
        ->format()->toBe('test')
        ->hasFormat()->toBeTrue();
});

it('evaluates', function () {
    $product = product();
    expect($this->test->format(fn (Product $product) => $product->name))
        ->evaluateFormat(['product' => $product])->toBe($product->name)
        ->hasFormat()->toBeTrue();
});

it('evaluates from model', function () {
    $product = product();
    expect($this->test->format(fn (Product $product) => $product->name))
        ->evaluateFormat($product)->toBe($product->name)
        ->hasFormat()->toBeTrue();
});