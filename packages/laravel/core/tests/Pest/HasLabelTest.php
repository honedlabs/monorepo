<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Tests\Stubs\Product;

beforeEach(function () {
    $this->test = new class {
        use Evaluable, HasLabel;
    };

    $this->param = 'label';
});

it('accesses', function () {
    expect($this->test)
        ->getLabel()->toBeNull()
        ->hasLabel()->toBeFalse()
        ->label($this->param)->toBe($this->test)
        ->getLabel()->toBe($this->param)
        ->hasLabel()->toBeTrue()
        ->label(fn () => $this->param)->toBe($this->test)
        ->getLabel()->toBe($this->param);
});

it('resolves', function () {
    $product = product();

    expect($this->test->label(fn (Product $product) => $product->name))
        ->resolveLabel(['product' => $product])->toBe($product->name);
});

it('converts', function () {
    expect($this->test)
        ->makeLabel(null)->toBeNull()
        ->makeLabel('new-label')->toBe('New label');
});
