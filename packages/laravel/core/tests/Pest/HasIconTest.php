<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Honed\Core\Contracts\Icon;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Tests\Stubs\Product;

enum IconEnum implements Icon
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

    $this->param = 'icon';
});

it('accesses', function () {
    expect($this->test)
        ->hasIcon()->toBeFalse()
        ->icon($this->param)->toBe($this->test)
        ->hasIcon()->toBeTrue();
});

it('accesses via contract', function () {
    expect($this->test)
        ->getIcon()->toBeNull()
        ->icon(IconEnum::Chevron)->toBe($this->test)
        ->getIcon()->toBe('chevron');
});

it('resolves', function () {
    $product = product();

    expect($this->test->icon(fn (Product $product) => $product->name))
        ->resolveIcon(['product' => $product])->toBe($product->name);
});
