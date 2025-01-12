<?php

declare(strict_types=1);

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\EvaluatesClosures;
use Honed\Core\Tests\Stubs\Product;

class EvaluatesClosuresTest
{
    use Evaluable;
    use Allowable;
    use EvaluatesClosures;
}

beforeEach(function () {
    $this->test = new EvaluatesClosuresTest;
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
