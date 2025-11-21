<?php

declare(strict_types=1);

use App\Models\Product;
use Honed\Form\Components\Legend;
use Honed\Form\Enums\FormComponent;
use Honed\Form\Form;
use Honed\Form\Support\Trans;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;

beforeEach(function () {
    $this->component = Legend::make('test');
});

it('defines a component', function () {
    expect($this->component)
        ->getComponent()->toBe(FormComponent::Legend->value)
        ->as('test')->toBe($this->component)
        ->getComponent()->toBe('test');
});

it('has array representation', function () {
    expect($this->component)
        ->toArray()->toEqualCanonicalizing([
            'label' => 'test',
            'component' => FormComponent::Legend->value,
        ]);
});

it('assigns properties', function () {
    expect($this->component)
        ->assign(['label' => 'assign'])->toBe($this->component)
        ->getLabel()->toBe('assign')
        ->assign(['label' => new Trans('assign')])->toBe($this->component)
        ->getLabel()->toBe(__('assign'));
});

it('sets class name', function () {
    expect($this->component)
        ->className('bg-red-500 text-white')->toBe($this->component)
        ->getAttributes()->toBe(['class' => 'bg-red-500 text-white']);
});

describe('evaluation', function () {
    beforeEach(function () {
        $this->product = Product::factory()->create();

        $this->form = Form::make()->record($this->product);
    });

    it('has named dependencies', function ($closure, $class) {
        expect($this->component)
            ->form($this->form)->toBe($this->component)
            ->evaluate($closure)->toBeInstanceOf($class);
    })->with([
        function () {
            return [fn ($model) => $model, Product::class];
        },
        function () {
            return [fn ($record) => $record, Product::class];
        },
        function () {
            return [fn ($row) => $row, Product::class];
        },
        function () {
            return [fn ($form) => $form, Form::class];
        },

    ]);

    it('has typed dependencies', function ($closure, $class) {
        expect($this->component)
            ->form($this->form)->toBe($this->component)
            ->evaluate($closure)->toBeInstanceOf($class);
    })->with([
        function () {
            return [fn (Form $arg) => $arg, Form::class];
        },
        function () {
            return [fn (Product $m) => $m, Product::class];
        },
        function () {
            return [fn (Model $r) => $r, Product::class];
        },
        function () {
            return [fn (Form $f) => $f, Form::class];
        },
    ]);

    it('does not evaluate typed dependencies when no record is set', function () {
        $this->component->evaluate(fn (Model $m) => $m);
    })->throws(BindingResolutionException::class);
});
