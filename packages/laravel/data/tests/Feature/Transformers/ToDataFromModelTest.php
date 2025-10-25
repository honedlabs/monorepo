<?php

declare(strict_types=1);

use App\Data\ProductData;
use App\Models\Product;
use App\Models\User;

beforeEach(function () {});

it('transforms an id to a data object', function () {
    $user = User::factory()->create();

    $product = Product::factory()->for($user)->create();

    $data = ProductData::from($product);

    expect($data)
        ->toArray()->toEqual([
            'user_id' => $user->id
        ]);

    expect($data)
        ->toForm()->toEqual([
            'user_id' => [
                'name' => $user->name,
            ]
        ]);
});
