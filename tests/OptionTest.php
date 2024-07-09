<?php

use Conquest\Core\Options\Option;
use Illuminate\Support\Facades\DB;
use Workbench\App\Component;
use Workbench\App\Enums\Lang;
use Workbench\App\Models\Category;

// use Workbench\App\Models\Category;
// use Workbench\Database\Factories\CategoryFactory;

it('can create an option', function () {
    $option = new Option(1);
    expect($option->getValue())->toBe(1);
    expect($option->getLabel())->toBe('1');
    expect($option->toArray())->toBe([
        'value' => 1,
        'label' => '1',
        'metadata' => [],
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
        'metadata' => [],
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

it('can set metadata', function () {
    expect($option = Option::make('value')->metadata($m = ['key' => 'value']))->toBeInstanceOf(Option::class);
    expect($option->getMetadata())->toBe($m);
});

it('can set active', function () {
    $option = new Option('value');
    $option->setActive(true);
    expect($option->isActive())->toBeTrue();
});

it('can parse an option', function () {
    $component = new Component();
    $option = $component->parseOption($v = 'value', $l = 'Label');
    expect($option)->toBeInstanceOf(Option::class);
    expect($option->getValue())->toBe($v);
    expect($option->getLabel())->toBe($l);

    // Category::factory(1)->create();
    // dd(Category::first());
});

it('can add an option', function () {
    $component = new Component();
    $component->addOption($option = Option::make('value'));
    expect($component->getOptions())->toBe([$option]);
});

it('checks if it has options', function () {
    $component = new Component();
    expect($component->hasOptions())->toBeFalse();
    $component->addOption(Option::make('value'));
    expect($component->hasOptions())->toBeTrue();
});

it('checks if it lacks options', function () {
    $component = new Component();
    expect($component->lacksOptions())->toBeTrue();
    $component->addOption(Option::make('value'));
    expect($component->lacksOptions())->toBeFalse();
});

it('can set option as single value', function () {
    $component = new Component();
    $component->setOptions([
        'value'
    ]);
    expect($component->getOptions())->toHaveCount(1);
    expect($component->getOptions()[0])->toBeInstanceOf(Option::class);
    expect($component->getOptions()[0]->getValue())->toBe('value');
    expect($component->getOptions()[0]->getLabel())->toBe('Value');
});

it('can set option as key value pair', function () {
    $component = new Component();
    $component->setOptions([
        'value' => 'Label',
    ]);
    expect($component->getOptions())->toHaveCount(1);
    expect($component->getOptions()[0])->toBeInstanceOf(Option::class);
    expect($component->getOptions()[0]->getValue())->toBe('value');
    expect($component->getOptions()[0]->getLabel())->toBe('Label');
});

it('can set option as Option instance', function () {
    $component = new Component();
    $component->setOptions([
        Option::make('value'),
    ]);
    expect($component->getOptions())->toHaveCount(1);
    expect($component->getOptions()[0])->toBeInstanceOf(Option::class);
    expect($component->getOptions()[0]->getValue())->toBe('value');
    expect($component->getOptions()[0]->getLabel())->toBe('Value');
});

it('can chain options', function () {
    $component = new Component();
    expect($component->options(['key' => 'value']))->toBeInstanceOf(Component::class);
    expect($component->hasOptions())->toBeTrue();
    expect($component->getOptions())->toHaveCount(1);
});

it('can chain options from enum using defaults', function () {
    $component = new Component();
    expect($component->optionsFromEnum(Lang::class))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount(count(Lang::cases()));
    expect($component->getOptions())->each(function ($option) {
        
        expect($enum = Lang::tryFrom($option->value->getValue()))
            ->toBeInstanceOf(Lang::class)
            ->and($enum->value)->toBe($option->value->getValue())
            ->and($enum->name)->toBe($option->value->getLabel());
    });
});

it('can chain options from enum using methods', function () {
    $component = new Component();
    expect($component->optionsFromEnum(Lang::class, null, 'label'))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount(count(Lang::cases()));
    expect($component->getOptions())->each(function ($option) {
        
        expect($enum = Lang::tryFrom($option->value->getValue()))
            ->toBeInstanceOf(Lang::class)
            ->and($enum->value)->toBe($option->value->getValue())
            ->and($enum->label())->toBe($option->value->getLabel());
    });
});

it('can chain options from model, defaulting to key', function () {
    $component = new Component();
    expect($component->optionsFromModel(Category::class))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount(Category::count());
    expect($component->getOptions())->each(function ($option) {
        expect($model = Category::find($option->value->getValue()))
            ->toBeInstanceOf(Category::class)
            ->and($model->getKey())->toBe($option->value->getValue())
            ->and(str($model->getKey()))->toBe($option->value->getLabel());
    });
});

it('can chain options from model using properties', function () {
    $component = new Component();
    expect($component->optionsFromModel(Category::class, 'slug', 'name'))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount(Category::count());
    expect($component->getOptions())->each(function ($option) {
        expect($model = Category::find($option->value->getValue()))
            ->toBeInstanceOf(Category::class)
            ->and($model->slug)->toBe($option->value->getValue())
            ->and(str($model->name))->toBe($option->value->getLabel());
    });
});

it('can chain options from model using method', function () {
    $component = new Component();
    expect($component->optionsFromModel(Category::class, 'url', 'name'))->toBeInstanceOf(Component::class);
    expect($component->getOptions())->toHaveCount(Category::count());
    expect($component->getOptions())->each(function ($option) {
        expect($model = Category::find($option->value->getValue()))
            ->toBeInstanceOf(Category::class)
            ->and($model->url())->toBe($option->value->getValue())
            ->and(str($model->name))->toBe($option->value->getLabel());
    });

});