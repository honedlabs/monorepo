<?php

declare(strict_types=1);

use App\Models\Product;
use Honed\Form\Components\Input;
use Honed\Form\Form;

beforeEach(function () {
    $this->component = Input::make('name');

    $this->form = Form::make();
});

it('belongs to form', function () {
    expect($this->component)
        ->getForm()->toBeNull()
        ->form($this->form)->toBe($this->component)
        ->getForm()->toBe($this->form);
});

it('gets record', function () {
    expect($this->component)
        ->getRecord()->toBeNull()
        ->form($this->form)->toBe($this->component)
        ->getRecord()->toBeNull();

    $this->form->record($product = Product::factory()->create());

    expect($this->component)
        ->form($this->form)->toBe($this->component)
        ->getRecord()->toBe($product);
});
