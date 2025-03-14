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
    $this->param = 'description';
});

it('sets', function () {
    expect($this->test->description($this->param))
        ->toBeInstanceOf(DescriptionTest::class)
        ->hasDescription()->toBeTrue();
});

it('gets', function () {
    expect($this->test->description($this->param))
        ->getDescription()->toBe($this->param)
        ->hasDescription()->toBeTrue();

    expect($this->test->description(fn () => $this->param))
        ->getDescription()->toBe($this->param)
        ->hasDescription()->toBeTrue();
});

it('resolves', function () {
    $product = product();

    expect($this->test->description(fn (Product $product) => $product->name))
        ->resolveDescription(['product' => $product])->toBe($product->name);
});
