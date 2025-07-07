<?php

use Workbench\App\Models\Product;
use Workbench\App\Http\Responses\CreateProduct;

beforeEach(function () {
    $this->product = Product::factory()->create();

    $this->store = route('products.store');

    $this->response = new CreateProduct($this->store);
})->only();

it('has store url', function () {
    expect($this->response)
        ->getStore()->toBe($this->store)
        ->store('/')->toBe($this->response)
        ->getStore()->toBe('/');
});

it('has store props', function () {
    expect($this->response)
        ->hasStoreToProps()
        ->scoped(fn ($store) => $store
            ->toBeArray()
            ->toHaveCount(1)
            ->toHaveKey(CreateProduct::STORE_PROP)
            ->{CreateProduct::STORE_PROP}->toBe($this->store)
        );
});