<?php

use App\Models\Product;
use Honed\Form\Data\SearchData;

beforeEach(function () {});

it('creates search data from source', function () {
    $data = SearchData::from([
        'value' => 1,
        'label' => 'Test',
    ]);

    expect($data)
        ->toArray()->toEqual([
            'value' => 1,
            'label' => 'Test',
        ]);
});

it('creates search data from model', function () {
    $product = Product::factory()->create();

    $data = SearchData::fromModel($product);

    expect($data)
        ->toArray()->toEqual([
            'value' => $product->getKey(),
            'label' => $product->name,
        ]);
});