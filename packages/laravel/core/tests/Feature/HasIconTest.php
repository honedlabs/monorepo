<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Honed\Core\Contracts\HasIcon as HasIconContract;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Tests\Stubs\Product;

beforeEach(function () {
    $this->test = new class {
        use Evaluable, HasIcon;
    };
});

it('accesses', function () {
    expect($this->test)
        ->defineIcon()->toBeNull()
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

it('defines', function () {
    $test = new class {
        use Evaluable, HasIcon;
        
        public function defineIcon()
        {
            return 'icon';
        }
    };

    expect($test)
        ->hasIcon()->toBeTrue()
        ->getIcon()->toBe('icon');
});

it('evaluates', function () {
    $product = product();

    expect($this->test)
        ->icon(fn (Product $product) => $product->name)->toBe($this->test)
        ->getIcon(['product' => $product])->toBe($product->name);
});
