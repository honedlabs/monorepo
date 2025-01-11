<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Tests\Stubs\Product;
use Honed\Core\Concerns\EvaluableDependency;

class EvaluableDependencyTest
{
    use Evaluable;
    use EvaluableDependency;
}

beforeEach(function () {
    $this->test = new EvaluableDependencyTest();
});

test('name `model`', function () {
    expect($this->test->allow(fn ($model) => $model->id > 100))
        ->isAllowed($this->product)->toBeFalse();
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

test('type model', function () {
    expect($this->test->allow(fn (\Illuminate\Database\Eloquent\Model $model) => $model->id > 100))
        ->allowsModel($this->product)->toBeFalse();
});

test('type model child', function () {
    expect($this->test->allow(fn (Product $product) => $product->id > 100))
        ->allowsModel($this->product)->toBeFalse();
});


