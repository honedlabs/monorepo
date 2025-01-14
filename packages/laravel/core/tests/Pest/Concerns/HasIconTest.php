<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Contracts\IsIcon;
use Honed\Core\Tests\Stubs\Product;

class IconTest
{
    use Evaluable;
    use HasIcon;
}

enum IconEnum implements IsIcon
{
    case Chevron;

    public function icon(): string
    {
        return 'chevron';
    }
}

beforeEach(function () {
    $this->test = new IconTest;
});

it('is null by default', function () {
    expect($this->test)
        ->hasIcon()->toBeFalse();
});

it('sets', function () {
    expect($this->test->icon('test'))
        ->toBeInstanceOf(IconTest::class)
        ->hasIcon()->toBeTrue();
});

it('gets', function () {
    expect($this->test->icon('test'))
        ->getIcon()->toBe('test')
        ->hasIcon()->toBeTrue();
});

it('gets icon interface', function () {
    expect($this->test->icon(IconEnum::Chevron))->toBeInstanceOf(IconTest::class)
        ->getIcon()->toBe('chevron')
        ->hasIcon()->toBeTrue();
});

it('evaluates', function () {
    $product = product();

    expect($this->test->icon(fn (Product $product) => $product->name))
        ->getIcon(['product' => $product])->toBe($product->name)
        ->hasIcon()->toBeTrue();
});

it('evaluates model', function () {
    $product = product();
    expect($this->test->icon(fn (Product $product) => $product->name))
        ->getIcon($product)->toBe($product->name)
        ->hasIcon()->toBeTrue();
});
