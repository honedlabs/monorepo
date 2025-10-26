<?php

declare(strict_types=1);

use App\Data\Validation\AuthorizedData;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('validates', function (mixed $input, bool $expected) {
    expect(Validator::make([
        'value' => $input,
    ], AuthorizedData::getValidationRules([
        'value' => $input,
    ])))->passes()->toBe($expected);
})->with([
    function () {
        $product = Product::factory()->for($this->user)->create();

        return [$product->getKey(), false];
    },
    function () {
        $product = Product::factory()->for($this->user)->create();

        $this->actingAs($this->user);

        return [$product->getKey(), true];
    },
    function () {
        $product = Product::factory()->create();

        $this->actingAs($this->user);

        return [$product->getKey(), false];
    },
]);
