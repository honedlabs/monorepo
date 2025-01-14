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

it('sets', function () {
    expect($this->test->label('test'))
        ->toBeInstanceOf(LabelTest::class)
        ->hasLabel()->toBeTrue();
});

it('gets', function () {
    expect($this->test->label('test'))
        ->getLabel()->toBe('test')
        ->hasLabel()->toBeTrue();
});

it('evaluates', function () {
    $product = product();

    expect($this->test->label(fn (Product $product) => $product->name))
        ->getLabel(['product' => $product])->toBe($product->name)
        ->hasLabel()->toBeTrue();
});

it('evaluates model', function () {
    $product = product();
    expect($this->test->label(fn (Product $product) => $product->name))
        ->getLabel($product)->toBe($product->name)
        ->hasLabel()->toBeTrue();
});

it('makes a label', function () {
    expect($this->test->makeLabel(null))->toBeNull();
    expect($this->test->makeLabel('new-Label'))->toBe('New label');
});
