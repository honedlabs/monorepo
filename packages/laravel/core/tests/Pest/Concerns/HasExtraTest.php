<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasExtra;
use Honed\Core\Tests\Stubs\Product;

class ExtraTest
{
    use Evaluable;
    use HasExtra;
}

beforeEach(function () {
    $this->test = new ExtraTest;
    $this->param = ['extra' => 'Extra'];
});


it('sets', function () {
    expect($this->test->extra($this->param))
        ->toBeInstanceOf(ExtraTest::class)
        ->hasExtra()->toBeTrue();
});


it('gets', function () {
    expect($this->test)
        ->getExtra()->scoped(fn ($extra) => $extra
            ->toBeArray()
            ->toBeEmpty()
        )
        ->hasExtra()->toBeFalse();

    expect($this->test->extra($this->param))
        ->getExtra()->toEqual($this->param)
        ->hasExtra()->toBeTrue();

});

it('resolves', function () {
    $product = product();

    expect($this->test->extra(fn (Product $product) => ['extra' => $product->name]))
        ->resolveExtra(['product' => $product])->toEqual(['extra' => $product->name])
        ->getExtra()->toEqual(['extra' => $product->name]);
});