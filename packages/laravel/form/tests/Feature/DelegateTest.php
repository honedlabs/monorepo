<?php

use Honed\Form\Delegate;
use App\Data\ProductData;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Honed\Form\Exceptions\CannotResolveGenerator;
use Honed\Form\Generators\DataGenerator;
use Honed\Form\Generators\RequestGenerator;

beforeEach(function () {});

it('delegates to data generator', function () {
    $generator = Delegate::to(ProductData::class);

    expect($generator)->toBeInstanceOf(DataGenerator::class);
});

it('delegates to request generator', function () {
    $generator = Delegate::to(ProductRequest::class);
    
    expect($generator)->toBeInstanceOf(RequestGenerator::class);
});

it('throws exception for invalid class', function () {
    Delegate::to(Product::class);
})->throws(CannotResolveGenerator::class);