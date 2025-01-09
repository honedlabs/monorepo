<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Tests\Stubs\Product;

class LabelTest
{
    use Evaluable;
    use HasLabel;
}

beforeEach(function () {
    $this->test = new LabelTest;
});

it('is null by default', function () {
    expect($this->test)
        ->label()->toBeNull()
        ->hasLabel()->toBeFalse();
});

it('sets', function () {
    expect($this->test->label('test'))
        ->toBeInstanceOf(LabelTest::class)
        ->label()->toBe('test')
        ->hasLabel()->toBeTrue();
});

it('gets', function () {
    expect($this->test->label('test'))
        ->label()->toBe('test')
        ->hasLabel()->toBeTrue();
});

it('evaluates', function () {
    $product = product();
    expect($this->test->label(fn (Product $product) => $product->name))
        ->evaluateLabel(['product' => $product])->toBe($product->name)
        ->hasLabel()->toBeTrue();
});

it('evaluates model', function () {
    $product = product();
    expect($this->test->label(fn (Product $product) => $product->name))
        ->evaluateLabel($product)->toBe($product->name)
        ->hasLabel()->toBeTrue();
});

it('makes label', function () {
    expect($this->test->makeLabel('lower-case'))->toBe('Lower case');
});
