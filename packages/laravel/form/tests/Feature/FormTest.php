<?php

declare(strict_types=1);

use App\Forms\ProductForm;
use App\Models\Product;
use Honed\Form\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->form = Form::make();
});

afterEach(function () {
    Form::flushState();
});

it('guesses form name', function () {
    Form::guessFormNamesUsing(function ($class) {
        return Str::of($class)
            ->classBasename()
            ->prepend('App\\Forms\\')
            ->append('Form')
            ->toString();
    });

    expect(ProductForm::resolveFormName(Product::class))
        ->toBe(ProductForm::class);

    expect(ProductForm::formForModel(Product::class))
        ->toBeInstanceOf(ProductForm::class);
});

it('uses namespace', function () {
    Form::useNamespace('');

    expect(ProductForm::resolveFormName(Product::class))
        ->toBe(class_basename(ProductForm::class));
});

it('has array representation', function () {
    expect($this->form)
        ->toArray()->toEqual([
            'schema' => [],
            'method' => mb_strtolower(Request::METHOD_POST),
        ]);
});

describe('evaluation', function () {
    it('has named dependencies', function ($closure, $class) {
        expect($this->form->evaluate($closure))->toBeInstanceOf($class);
    })->with([
        'form' => fn () => [fn ($form) => $form, Form::class],
    ]);

    it('has typed dependencies', function ($closure, $class) {
        expect($this->form->evaluate($closure))->toBeInstanceOf($class);
    })->with([
        'form' => fn () => [fn (Form $arg) => $arg, Form::class],
    ]);
});
