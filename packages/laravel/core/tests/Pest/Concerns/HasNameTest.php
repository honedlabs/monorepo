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
    $this->param = 'name';
});

it('sets', function () {
    expect($this->test->name($this->param))
        ->toBeInstanceOf(NameTest::class)
        ->hasName()->toBeTrue();
});

it('gets', function () {
    expect($this->test->name($this->param))
        ->getName()->toBe($this->param)
        ->hasName()->toBeTrue();

    expect($this->test->name(fn () => $this->param))
        ->getName()->toBe($this->param)
        ->hasName()->toBeTrue();
});

it('resolves', function () {
    $product = product();

    expect($this->test->name(fn (Product $product) => $product->name))
        ->resolveName(['product' => $product])->toBe($product->name)
        ->getName()->toBe($product->name);
});

it('converts', function () {
    expect($this->test->makeName(null))->toBeNull();
    expect($this->test->makeName('New label'))->toBe('new_label');
});
