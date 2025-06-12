<?php

use Workbench\App\Actions\Product\DestroyProduct;
use Workbench\App\Models\Product;
use Workbench\App\Models\User;

beforeEach(function () {
    $this->action = new DestroyProduct();

    $this->product = Product::factory()->create();

    $this->assertDatabaseHas('products', [
        'id' => $this->product->id,
    ]);
});

it('destroys a model', function () {
    $this->action->handle($this->product);

    $this->assertSoftDeleted('products', [
        'id' => $this->product->id,
    ]);
});

it('destroys multiple models from collection', function () {
    $products = Product::factory()
        ->count(3)
        ->create();

    $this->action->handle($products);

    $this->assertNotSoftDeleted('products', [
        'id' => $this->product->id,
    ]);

    $products->each(function ($product) {
        $this->assertSoftDeleted('products', [
            'id' => $product->id,
        ]);
    });
});

it('destroy models from builder', function () {
    $products = Product::factory()
        ->count(3)
        ->create();

    $this->action->handle(Product::query()->whereIn('id', $products->pluck('id')));

    $this->assertNotSoftDeleted('products', [
        'id' => $this->product->id,
    ]);

    $products->each(function ($product) {
        $this->assertSoftDeleted('products', [
            'id' => $product->id,
        ]);
    });
});

it('destroys models from relationship', function () {
    $user = User::query()->find(1);

    $products = Product::factory()
        ->count(3)
        ->create();

    $this->action->handle($user->products());

    $this->assertSoftDeleted('products', [
        'id' => $this->product->id,
    ]);

    $products->each(function ($product) {
        $this->assertNotSoftDeleted('products', [
            'id' => $product->id,
        ]);
    });
});