<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasParameterNames;
use Honed\Core\Tests\Stubs\Product;
use Honed\Core\Tests\Stubs\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

beforeEach(function () {
    $this->test = new class
    {
        use HasParameterNames;
    };

    $this->names = [
        Product::class,
        'product',
        'products',
    ];
});

it('gets names from builder', function () {
    expect($this->test->getParameterNames(Product::query()))->toBe($this->names);
});

it('gets names from model', function () {
    expect($this->test->getParameterNames(product()))->toBe($this->names);
});

it('gets names from class name', function () {
    expect($this->test->getParameterNames(Product::class))->toBe($this->names);
});

it('gets singular name', function () {
    expect($this->test->getSingularName(Product::class))->toBe($this->names[1]);
});

it('gets plural name', function () {
    expect($this->test->getPluralName(Product::class))->toBe($this->names[2]);
});

it('checks if builder parameter', function () {
    expect($this->test)
        ->isBuilder('builder', Status::class)->toBeTrue()
        ->isBuilder('status', Builder::class)->toBeTrue()
        ->isBuilder('status', Status::class)->toBeFalse();
});

it('checks if collection parameter', function () {
    expect($this->test)
        ->isCollection('collection', Status::class)->toBeTrue()
        ->isCollection('status', Collection::class)->toBeTrue()
        ->isCollection('status', Status::class)->toBeFalse();
});

it('checks if model parameter', function () {
    expect($this->test)
        ->isModel('model', Status::class, Product::class)->toBeTrue()
        ->isModel('status', Product::class, Product::class)->toBeTrue()
        ->isModel('status', Status::class, Product::class)->toBeFalse();
});

it('gets builder parameters', function () {
    $product = product();

    $named = ['model', 'record', 'query', 'builder', 'products', 'product'];

    $typed = [Model::class, Builder::class, Product::class];

    expect($this->test->getBuilderParameters(Product::class, $product))
        ->toBeArray()
        ->toHaveCount(2)
        ->{0}->toHaveKeys($named)
        ->{1}->toHaveKeys($typed);
});
it('gets model parameters', function () {
    $product = product();

    $named = ['model', 'record', 'product'];

    $typed = [Model::class, Product::class];

    expect($this->test->getModelParameters(Product::class, $product))
        ->toBeArray()
        ->toHaveCount(2)
        ->{0}->toHaveKeys($named)
        ->{1}->toHaveKeys($typed);
});
