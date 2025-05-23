<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Tests\Stubs\Product;

beforeEach(function () {
    $this->test = new class {
        use Evaluable, HasLabel;
    };
});

it('accesses', function () {
    expect($this->test)
        ->getLabel()->toBeNull()
        ->hasLabel()->toBeFalse()
        ->label('label')->toBe($this->test)
        ->getLabel()->toBe('label')
        ->hasLabel()->toBeTrue();
});

it('evaluates', function () {
    $product = product();

    expect($this->test)
        ->label(fn (Product $product) => $product->name)->toBe($this->test)
        ->getLabel(['product' => $product])->toBe($product->name);
});

it('makes', function () {
    expect($this->test)
        ->makeLabel(null)->toBeNull()
        ->makeLabel('new-label')->toBe('New label');
});
