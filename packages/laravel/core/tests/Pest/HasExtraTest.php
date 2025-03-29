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

it('accesses via contract', function () {
    $test = new class implements HasExtraContract {
        use Evaluable, HasExtra;

        public function extraAs()
        {
            return ['key' => 'value'];
        }
    };

    expect($test->getExtra())->toEqual(['key' => 'value']);
});

it('resolves', function () {
    $product = product();

    expect($this->test->extra(fn (Product $product) => ['extra' => $product->name]))
        ->resolveExtra(['product' => $product])->toEqual(['extra' => $product->name]);
});
