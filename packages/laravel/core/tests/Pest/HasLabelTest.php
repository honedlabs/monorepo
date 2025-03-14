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
    $this->param = 'label';
});

it('sets', function () {
    expect($this->test->label($this->param))
        ->toBeInstanceOf(LabelTest::class)
        ->hasLabel()->toBeTrue();
});

it('gets', function () {
    expect($this->test->label($this->param))
        ->getLabel()->toBe($this->param)
        ->hasLabel()->toBeTrue();

    expect($this->test->label(fn () => $this->param))
        ->getLabel()->toBe($this->param)
        ->hasLabel()->toBeTrue();
});

it('resolves', function () {
    $product = product();

    expect($this->test->label(fn (Product $product) => $product->name))
        ->resolveLabel(['product' => $product])->toBe($product->name);
});

it('converts', function () {
    expect($this->test->makeLabel(null))->toBeNull();
    expect($this->test->makeLabel('new-Label'))->toBe('New label');
});
