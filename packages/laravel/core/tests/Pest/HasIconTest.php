<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Honed\Core\Contracts\HasIcon as HasIconContract;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Tests\Stubs\Product;

enum IconEnum implements HasIconContract
{
    case Chevron;

    public function icon(): string
    {
        return Str::of($this->name)
            ->lower()
            ->value();
    }
}

beforeEach(function () {
    $this->test = new class {
        use Evaluable, HasIcon;
    };
});

it('accesses', function () {
    expect($this->test)
        ->hasIcon()->toBeFalse()
        ->getIcon()->toBeNull()
        ->icon('icon')->toBe($this->test)
        ->getIcon()->toBe('icon')
        ->hasIcon()->toBeTrue();
});

it('accesses contracts', function () {
    expect($this->test)
        ->hasIcon()->toBeFalse()
        ->getIcon()->toBeNull()
        ->icon(IconEnum::Chevron)->toBe($this->test)
        ->getIcon()->toBe('chevron')
        ->hasIcon()->toBeTrue();
});

it('evaluates', function () {
    $product = product();

    expect($this->test)
        ->icon(fn (Product $product) => $product->name)->toBe($this->test)
        ->getIcon(['product' => $product])->toBe($product->name);
});
