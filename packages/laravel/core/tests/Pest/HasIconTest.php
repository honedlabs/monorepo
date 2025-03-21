<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Contracts\Icon;
use Honed\Core\Tests\Stubs\Product;

class IconTest
{
    use Evaluable;
    use HasIcon;
}

enum IconEnum implements Icon
{
    case Chevron;

    public function icon(): string
    {
        return 'chevron';
    }
}

beforeEach(function () {
    $this->test = new IconTest;
    $this->param = 'icon';
});

it('is null by default', function () {
    expect($this->test)
        ->hasIcon()->toBeFalse();
});

it('sets', function () {
    expect($this->test->icon($this->param))
        ->toBeInstanceOf(IconTest::class)
        ->hasIcon()->toBeTrue();
});

it('gets', function () {
    expect($this->test->icon($this->param))
        ->getIcon()->toBe($this->param)
        ->hasIcon()->toBeTrue();
});

it('gets via contract', function () {
    expect($this->test->icon(IconEnum::Chevron))->toBeInstanceOf(IconTest::class)
        ->getIcon()->toBe(IconEnum::Chevron->icon())
        ->hasIcon()->toBeTrue();
});

it('resolves', function () {
    $product = product();

    expect($this->test->icon(fn (Product $product) => $product->name))
        ->resolveIcon(['product' => $product])->toBe($product->name);
});
