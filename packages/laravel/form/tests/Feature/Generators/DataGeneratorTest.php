<?php

declare(strict_types=1);

use App\Models\Product;
use Spatie\LaravelData\Data;
use Honed\Form\Generators\DataGenerator;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\FromAuthenticatedUserProperty;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Attributes\InjectsPropertyValue;

beforeEach(function () {
    $this->generator = app(DataGenerator::class);
})->only();

it('skips properties', function (bool $expected, Data $data) {
    expect($this->generator)
        ->shouldSkip(property($data))->toBe($expected);
})->with([
    fn () => [true, new class() extends Data
    {
        #[Computed]
        public int $user_id;
    }],
    fn () => [true, new class() extends Data
    {
        #[FromAuthenticatedUserProperty(property: 'id')]
        public int $user_id;
    }],
    fn () => [false, new class() extends Data
    {
        public int $user_id;
    }],
]);

it('gets empty data', function (array $expected, Data $data) {
    expect($this->generator)
        ->for($data::class)->toBe($this->generator)
        ->getData()->toBe($expected);
})->with([
    fn () => [['user_id' => null], new class() extends Data
    {
        public int $user_id;
    }],
]);

it('gets payload data', function (Data $data, mixed $payload, array $expected) {
    expect($this->generator)
        ->for($data::class)->toBe($this->generator)
        ->getData($payload)->toBe($expected);
})->with([
    function () {
        $product = Product::factory()->create();

        $data = new class() extends Data
        {
            public int $user_id;
        };

        return [$data, $product, ['user_id' => $product->user_id]];
    },
]);