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
    $this->param = 'format';
});

it('sets', function () {
    expect($this->test->format($this->param))
        ->toBeInstanceOf(FormatTest::class)
        ->hasFormat()->toBeTrue();
});

it('gets', function () {
    expect($this->test->format($this->param))
        ->getFormat()->toBe($this->param)
        ->hasFormat()->toBeTrue();

    expect($this->test->format(fn () => $this->param))
        ->getFormat()->toBe($this->param)
        ->hasFormat()->toBeTrue();
});

it('resolves', function () {
    $product = product();

    expect($this->test->format(fn (Product $product) => $product->name))
        ->resolveFormat(['product' => $product])->toBe($product->name);
});
