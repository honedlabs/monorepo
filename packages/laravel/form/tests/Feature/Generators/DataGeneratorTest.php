<?php

declare(strict_types=1);

use App\Data\ProductData;
use App\Enums\Status;
use App\Models\Product;
use Honed\Form\Enums\FormComponent;
use Honed\Form\Generators\DataGenerator;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\FromAuthenticatedUserProperty;
use Spatie\LaravelData\Data;

beforeEach(function () {
    $this->generator = app(DataGenerator::class);
});

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

it('generates form without payload', function () {
    expect($this->generator)
        ->for(ProductData::class)->toBe($this->generator)
        ->generate()
        ->scoped(fn ($form) => $form
            ->toArray()->toEqual([
                'method' => mb_strtolower(Request::METHOD_POST),
                'schema' => [
                    [
                        'component' => FormComponent::Search->value,
                        'name' => 'user',
                        'label' => 'User',
                        'defaultValue' => [
                            'name' => null,
                            'email' => null,
                        ],
                        'options' => [],
                        'url' => route('users.index'),
                        'method' => mb_strtolower(Request::METHOD_GET),
                    ],
                    [
                        'component' => FormComponent::Input->value,
                        'name' => 'name',
                        'label' => 'Name',
                        'required' => true,
                    ],
                    [
                        'component' => FormComponent::Textarea->value,
                        'name' => 'description',
                        'label' => 'Description',
                    ],
                    [
                        'component' => FormComponent::Number->value,
                        'name' => 'price',
                        'label' => 'Price',
                        'required' => true,
                    ],
                    [
                        'component' => FormComponent::Checkbox->value,
                        'name' => 'best_seller',
                        'label' => 'Best seller',
                        'required' => true,
                    ],
                    [
                        'component' => FormComponent::Select->value,
                        'name' => 'status',
                        'label' => 'Status',
                        'defaultValue' => Status::Available,
                        'required' => true,
                        'options' => [
                            [
                                'value' => Status::Available->value,
                                'label' => Status::Available->name,
                            ],
                            [
                                'value' => Status::Unavailable->value,
                                'label' => Status::Unavailable->name,
                            ],
                            [
                                'value' => Status::ComingSoon->value,
                                'label' => Status::ComingSoon->name,
                            ],
                        ],
                    ],
                    [
                        'component' => FormComponent::Input->value,
                        'name' => 'users',
                        'label' => 'Users',
                        'defaultValue' => [],
                        'required' => true,
                    ],
                ],
            ])
        );
});
