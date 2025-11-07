<?php

declare(strict_types=1);

use App\Forms\ProductForm;
use App\Models\Product;
use Honed\Form\Enums\FormComponent;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->form = ProductForm::make();
});

it('can be create form', function () {
    expect($this->form)
        ->toArray()->toEqualCanonicalizing([
            'method' => mb_strtolower(Request::METHOD_POST),
            'action' => '/products',
            'cancel' => '/products',
            'schema' => [
                [
                    'component' => FormComponent::Fieldset->value,
                    'schema' => [
                        [
                            'component' => FormComponent::Legend->value,
                            'label' => 'Product details',
                        ],
                        [
                            'component' => FormComponent::Text->value,
                            'text' => 'Enter the details of the product.',
                        ],
                        [
                            'component' => FormComponent::FieldGroup->value,
                            'schema' => [
                                [
                                    'component' => FormComponent::Input->value,
                                    'name' => 'name',
                                    'label' => 'Name',
                                    'value' => '',
                                    'required' => true,
                                ],
                                [
                                    'component' => FormComponent::Textarea->value,
                                    'name' => 'description',
                                    'label' => 'Description',
                                    'value' => '',
                                    'required' => true,
                                ],
                                [
                                    'component' => FormComponent::Input->value,
                                    'name' => 'price',
                                    'label' => 'Price',
                                    'value' => '',
                                    'required' => true,
                                ],
                                [
                                    'component' => 'combobox',
                                    'name' => 'user_id',
                                    'label' => 'User',
                                ],
                                [
                                    'component' => FormComponent::Checkbox->value,
                                    'name' => 'best_seller',
                                    'label' => 'Best seller',
                                    'value' => false,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
});

it('can be update form', function () {
    expect($this->form)
        ->record($product = Product::factory()->create())
        ->toArray()->toEqualCanonicalizing([
            'method' => mb_strtolower(Request::METHOD_POST),
            'action' => '/products',
            'cancel' => '/products',
            'schema' => [
                [
                    'component' => FormComponent::Fieldset->value,
                    'schema' => [
                        [
                            'component' => FormComponent::Legend->value,
                            'label' => 'Product details',
                        ],
                        [
                            'component' => FormComponent::Text->value,
                            'text' => 'Enter the details of the product.',
                        ],
                        [
                            'component' => FormComponent::FieldGroup->value,
                            'schema' => [
                                [
                                    'component' => FormComponent::Input->value,
                                    'name' => 'name',
                                    'label' => 'Name',
                                    'value' => $product->name,
                                    'required' => true,
                                ],
                                [
                                    'component' => FormComponent::Textarea->value,
                                    'name' => 'description',
                                    'label' => 'Description',
                                    'value' => $product->description,
                                    'required' => true,
                                ],
                                [
                                    'component' => FormComponent::Input->value,
                                    'name' => 'price',
                                    'label' => 'Price',
                                    'value' => $product->price,
                                    'required' => true,
                                ],
                                [
                                    'component' => 'combobox',
                                    'name' => 'user_id',
                                    'label' => 'User',
                                    'value' => $product->user_id,
                                ],
                                [
                                    'component' => FormComponent::Checkbox->value,
                                    'name' => 'best_seller',
                                    'label' => 'Best seller',
                                    'value' => $product->best_seller,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

});
