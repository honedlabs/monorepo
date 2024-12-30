<?php

use Honed\Core\Options\Option;
use Honed\Core\Tests\Stubs\Status;
use Honed\Core\Tests\Stubs\Product;
use Honed\Core\Tests\Stubs\Component;

it('can create an option', function () {
    $option = new Option(1);
    expect($option->getValue())->toBe(1);
    expect($option->getLabel())->toBe('1');
    expect($option->toArray())->toBe([
        'value' => 1,
        'label' => '1',
        'meta' => [],
        'active' => false,
    ]);
});

it('can make an option', function () {
    expect($option = Option::make($v = 'value'))->toBeInstanceOf(Option::class);
    expect($option->getValue())->toBe($v);
    expect($option->getLabel())->toBe($l = 'Value');
    expect($option->toArray())->toBe([
        'value' => $v,
        'label' => $l,
        'meta' => [],
        'active' => false,
    ]);
});

it('can set a value', function () {
    expect($option = Option::make('value')->value(1))->toBeInstanceOf(Option::class);
    expect($option->getValue())->toBe(1);
});

it('can set a label', function () {
    expect($option = Option::make('value')->label('New Value'))->toBeInstanceOf(Option::class);
    expect($option->getLabel())->toBe('New Value');
});

it('can set meta', function () {
    expect($option = Option::make('value')->meta($m = ['key' => 'value']))->toBeInstanceOf(Option::class);
    expect($option->getMeta())->toBe($m);
});

it('can set active', function () {
    $option = new Option('value');
    $option->setActive(true);
    expect($option->isActive())->toBeTrue();
});

it('can add an option', function () {
    $component = new Component;
    $component->addOption($option = Option::make('value'));
    expect($component->getOptions())->toBe([$option]);
});

it('checks if it has options', function () {
    $component = new Component;
    expect($component->hasOptions())->toBeFalse();
    $component->addOption(Option::make('value'));
    expect($component->hasOptions())->toBeTrue();
});

it('can set option as single value', function () {
    $component = new Component;
    $component->setOptions([
        'value',
    ]);
    expect($component->getOptions())->toHaveCount(1);
    expect($component->getOptions()[0])->toBeInstanceOf(Option::class);
    expect($component->getOptions()[0]->getValue())->toBe('value');
    expect($component->getOptions()[0]->getLabel())->toBe('Value');
});

it('can set option as key value pair', function () {
    $component = new Component;
    $component->setOptions([
        'value' => 'Label',
    ]);
    expect($component->getOptions())->toHaveCount(1);
    expect($component->getOptions()[0])->toBeInstanceOf(Option::class);
    expect($component->getOptions()[0]->getValue())->toBe('value');
    expect($component->getOptions()[0]->getLabel())->toBe('Label');
});

it('can set option as Option instance', function () {
    $component = new Component;
    $component->setOptions([
        Option::make('value'),
    ]);
    expect($component->getOptions())->toHaveCount(1);
    expect($component->getOptions()[0])->toBeInstanceOf(Option::class);
    expect($component->getOptions()[0]->getValue())->toBe('value');
    expect($component->getOptions()[0]->getLabel())->toBe('Value');
});

it('can chain options', function () {
    $component = new Component;
    expect($component->options(['key' => 'value']))->toBeInstanceOf(Component::class);
    expect($component->hasOptions())->toBeTrue();
    expect($component->getOptions())->toHaveCount(1);
});

it('can chain options from enum using defaults', function () {
    $component = new Component;
    expect($component->fromEnum(Status::class))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount(count(Status::cases()));
    expect($component->getOptions())->each(function ($option) {

        expect($enum = Status::tryFrom($option->value->getValue()))
            ->toBeInstanceOf(Status::class)
            ->and($option->value->getValue())->toBe($enum->value)
            ->and($option->value->getLabel())->toBe($enum->name);
    });
});

it('can chain options from enum using methods', function () {
    $component = new Component;
    expect($component->fromEnum(Status::class, null, 'label'))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount(count(Status::cases()));
    expect($component->getOptions())->each(function ($option) {

        expect($enum = Status::tryFrom($option->value->getValue()))
            ->toBeInstanceOf(Status::class)
            ->and($option->value->getValue())->toBe($enum->value)
            ->and($option->value->getLabel())->toBe($enum->label());
    });
});

it('can chain options from model, defaulting to key', function () {
    $component = new Component;
    expect($component->fromModel(Product::class))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount(Product::count());
    expect($component->getOptions())->each(function ($option) {
        expect($model = Product::find($option->value->getValue()))
            ->toBeInstanceOf(Product::class)
            ->and($option->value->getValue())->toBe($model->getKey())
            ->and($option->value->getLabel())->toBe((string) $model->getKey());
    });
});

it('can chain options from model using properties', function () {
    $component = new Component;
    expect($component->fromModel(Product::class, 'slug', 'name'))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount(Product::count());
    expect($component->getOptions())->each(function ($option) {
        expect($model = Product::where('slug', $option->value->getValue())->first())
            ->toBeInstanceOf(Product::class)
            ->and($option->value->getValue())->toBe($model->slug)
            ->and($option->value->getLabel())->toBe((string) $model->name);
    });
});

it('can chain options from model using method', function () {
    $component = new Component;
    expect($component->fromModel(Product::class, 'url', 'name'))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount(Product::count());
    expect($component->getOptions())->each(function ($option) {
        expect($model = Product::where('name', $option->value->getLabel())->first())
            ->toBeInstanceOf(Product::class)
            ->and($model->url())->toBe($option->value->getValue())
            ->and($model->name)->toBe($option->value->getLabel());
    });
});

it('can chain options from collection, defaulting to the item itself', function () {
    $component = new Component;
    expect($component->fromCollection($c = Product::select('name', 'slug')->get()))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount($c->count());
    expect($component->getOptions())->toHaveCount($c->count());
});

it('can chain options from collection using properties', function () {
    $component = new Component;
    expect($component->fromCollection($c = Product::select('name', 'slug')->get(), 'slug', 'name'))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount($c->count());
    expect($component->getOptions())->each(function ($option) use ($c) {
        expect($model = $c->where('slug', $option->value->getValue())->first())
            ->toBeInstanceOf(Product::class)
            ->and($option->value->getValue())->toBe($model->slug)
            ->and($option->value->getLabel())->toBe((string) $model->name);
    });
});

it('does not allow for nulls to be set', function () {
    $component = new Component;
    $component->setOptions(null);
    expect($component->getOptions())->toBeEmpty();
});
