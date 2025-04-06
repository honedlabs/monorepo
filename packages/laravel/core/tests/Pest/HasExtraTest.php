<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasExtra;
use Honed\Core\Contracts\HasExtra as HasExtraContract;
use Honed\Core\Tests\Stubs\Product;

beforeEach(function () {
    $this->test = new class {
        use Evaluable, HasExtra;
    };
});

it('accesses', function () {
    expect($this->test)
        ->getExtra()->scoped(fn ($test) => $test
            ->toBeArray()
            ->toBeEmpty()
        )
        ->hasExtra()->toBeFalse()
        ->extra(['key' => 'value'])->toBe($this->test)
        ->getExtra()->toEqual(['key' => 'value'])
        ->hasExtra()->toBeTrue();
});

it('defines', function () {
    $test = new class {
        use Evaluable, HasExtra;

        public function defineExtra()
        {
            return ['key' => 'value'];
        }
    };

    expect($test)
        ->getExtra()->toEqual(['key' => 'value'])
        ->hasExtra()->toBeTrue();
});


it('evaluates', function () {
    $product = product();

    expect($this->test)
        ->extra(fn (Product $product) => ['extra' => $product->name])->toBe($this->test)
        ->getExtra(['product' => $product])->toEqual(['extra' => $product->name]);
});
