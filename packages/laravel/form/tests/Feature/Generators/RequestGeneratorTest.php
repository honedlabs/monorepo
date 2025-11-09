<?php

declare(strict_types=1);

use App\Http\Requests\ProductRequest;
use Honed\Form\Enums\FormComponent;
use Honed\Form\Generators\RequestGenerator;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->generator = app(RequestGenerator::class);
});

it('generates form from request', function () {
    expect($this->generator)
        ->for(ProductRequest::class)->toBe($this->generator)
        ->generate()
        ->scoped(fn ($form) => $form
            ->toArray()->toEqual([
                'method' => mb_strtolower(Request::METHOD_POST),
                'schema' => [
                    [
                        'component' => FormComponent::Input->value,
                        'name' => 'name',
                        'label' => 'Name',
                    ],
                    [
                        'component' => FormComponent::Input->value,
                        'name' => 'description',
                        'label' => 'Description',
                    ],
                    [
                        'component' => FormComponent::Input->value,
                        'name' => 'price',
                        'label' => 'Price',
                    ],
                    [
                        'component' => FormComponent::Checkbox->value,
                        'name' => 'best_seller',
                        'label' => 'Best seller',
                        'defaultValue' => false,
                    ],
                    [
                        'component' => FormComponent::Input->value,
                        'name' => 'status',
                        'label' => 'Status',
                    ],
                    [
                        'component' => FormComponent::Input->value,
                        'name' => 'user_id',
                        'label' => 'User id',
                    ],
                    [
                        'component' => FormComponent::Input->value,
                        'name' => 'users',
                        'label' => 'Users',
                    ],
                    [
                        'component' => FormComponent::Input->value,
                        'name' => 'users.*',
                        'label' => '*',
                    ],
                ],
            ]));
});
