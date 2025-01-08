<?php

declare(strict_types=1);

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Tests\Stubs\Product;

class AllowableTest
{
    use Allowable;
    use Evaluable;
}

beforeEach(function () {
    $this->test = new AllowableTest;
});

it('allows by default', function () {
    expect($this->test)
        ->allows()->toBeTrue();
});

it('sets', function () {
    expect($this->test->allow(false))
        ->toBeInstanceOf(AllowableTest::class)
        ->allows()->toBeFalse();
});

it('evaluates', function () {
    expect($this->test->allow(fn (Product $product) => $product->id > 100))
        ->allows(['product' => product()])->toBeFalse();
});

describe('allows model', function () {
    beforeEach(function () {
        $this->product = product();
    });

    test('name `model`', function () {
        expect($this->test->allow(fn ($model) => $model->id > 100))
            ->allowsModel($this->product)->toBeFalse();
    });

    test('name `record`', function () {
        expect($this->test->allow(fn ($record) => $record->id > 100))
            ->allowsModel($this->product)->toBeFalse();
    });

    test('name `resource`', function () {
        expect($this->test->allow(fn ($resource) => $resource->id > 100))
            ->allowsModel($this->product)->toBeFalse();
    });

    test('name from table', function () {
        expect($this->test->allow(fn ($product) => $product->id > 100))
            ->allowsModel($this->product)->toBeFalse();
    });

    test('type \Illuminate\Database\Eloquent\Model', function () {
        expect($this->test->allow(fn (\Illuminate\Database\Eloquent\Model $model) => $model->id > 100))
            ->allowsModel($this->product)->toBeFalse();
    });

    test('type Product', function () {
        expect($this->test->allow(fn (Product $product) => $product->id > 100))
            ->allowsModel($this->product)->toBeFalse();
    });
});


