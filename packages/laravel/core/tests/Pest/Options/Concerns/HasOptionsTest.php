<?php

declare(strict_types=1);

use Honed\Core\Options\Option;
use Honed\Core\Tests\Stubs\Status;
use Honed\Core\Tests\Stubs\Product;
use Honed\Core\Options\Concerns\HasOptions;

class HasOptionsComponent
{
    use HasOptions;
}

beforeEach(function () {
    $this->component = new HasOptionsComponent;
});

it('adds an option', function () {
    $this->component->addOption($option = Option::make('value'));
    expect($this->component->getOptions())->toBe([$option]);
});

it('checks if it has options', function () {
    $component = new HasOptionsComponent;
    expect($component->hasOptions())->toBeFalse();
    $component->addOption(Option::make('value'));
    expect($component->hasOptions())->toBeTrue();
});

it('can set option as single value', function () {
    $component = new HasOptionsComponent;
    $component->setOptions([
        'value',
    ]);
    expect($component->getOptions())->toHaveCount(1);
    expect($component->getOptions()[0])->toBeInstanceOf(Option::class);
    expect($component->getOptions()[0]->getValue())->toBe('value');
    expect($component->getOptions()[0]->getLabel())->toBe('Value');
});

it('can set option as key value pair', function () {
    $component = new HasOptionsComponent;
    $component->setOptions([
        'value' => 'Label',
    ]);
    expect($component->getOptions())->toHaveCount(1);
    expect($component->getOptions()[0])->toBeInstanceOf(Option::class);
    expect($component->getOptions()[0]->getValue())->toBe('value');
    expect($component->getOptions()[0]->getLabel())->toBe('Label');
});

it('can set option as Option instance', function () {
    $component = new HasOptionsComponent;
    $component->setOptions([
        Option::make('value'),
    ]);
    expect($component->getOptions())->toHaveCount(1);
    expect($component->getOptions()[0])->toBeInstanceOf(Option::class);
    expect($component->getOptions()[0]->getValue())->toBe('value');
    expect($component->getOptions()[0]->getLabel())->toBe('Value');
});

it('can chain options', function () {
    $component = new HasOptionsComponent;
    expect($component->options(['key' => 'value']))->toBeInstanceOf(HasOptionsComponent::class);
    expect($component->hasOptions())->toBeTrue();
    expect($component->getOptions())->toHaveCount(1);
});

it('can chain options from enum using defaults', function () {
    $component = new HasOptionsComponent;
    expect($component->fromEnum(Status::class))->toBeInstanceOf(HasOptionsComponent::class);
    expect($component->getOptions())->toHaveCount(count(Status::cases()));
    expect($component->getOptions())->each(function ($option) {

        expect($enum = Status::tryFrom($option->value->getValue()))
            ->toBeInstanceOf(Status::class)
            ->and($option->value->getValue())->toBe($enum->value)
            ->and($option->value->getLabel())->toBe($enum->name);
    });
});

it('can chain options from enum using methods', function () {
    $component = new HasOptionsComponent;
    expect($component->fromEnum(Status::class, null, 'label'))->toBeInstanceOf(HasOptionsComponent::class);
    expect($component->getOptions())->toHaveCount(count(Status::cases()));
    expect($component->getOptions())->each(function ($option) {

        expect($enum = Status::tryFrom($option->value->getValue()))
            ->toBeInstanceOf(Status::class)
            ->and($option->value->getValue())->toBe($enum->value)
            ->and($option->value->getLabel())->toBe($enum->label());
    });
});

it('can chain options from model, defaulting to key', function () {
    $component = new HasOptionsComponent;
    expect($component->fromModel(Product::class))->toBeInstanceOf(HasOptionsComponent::class);
    expect($component->getOptions())->toHaveCount(Product::count());
    expect($component->getOptions())->each(function ($option) {
        expect($model = Product::find($option->value->getValue()))
            ->toBeInstanceOf(Product::class)
            ->and($option->value->getValue())->toBe($model->getKey())
            ->and($option->value->getLabel())->toBe((string) $model->getKey());
    });
});

it('can chain options from model using properties', function () {
    $component = new HasOptionsComponent;
    expect($component->fromModel(Product::class, 'slug', 'name'))->toBeInstanceOf(HasOptionsComponent::class);
    expect($component->getOptions())->toHaveCount(Product::count());
    expect($component->getOptions())->each(function ($option) {
        expect($model = Product::where('slug', $option->value->getValue())->first())
            ->toBeInstanceOf(Product::class)
            ->and($option->value->getValue())->toBe($model->slug)
            ->and($option->value->getLabel())->toBe((string) $model->name);
    });
});

it('can chain options from model using method', function () {
    $component = new HasOptionsComponent;
    expect($component->fromModel(Product::class, 'url', 'name'))->toBeInstanceOf(HasOptionsComponent::class);
    expect($component->getOptions())->toHaveCount(Product::count());
    expect($component->getOptions())->each(function ($option) {
        expect($model = Product::where('name', $option->value->getLabel())->first())
            ->toBeInstanceOf(Product::class)
            ->and($model->url())->toBe($option->value->getValue())
            ->and($model->name)->toBe($option->value->getLabel());
    });
});

it('can chain options from collection, defaulting to the item itself', function () {
    $component = new HasOptionsComponent;
    expect($component->fromCollection($c = Product::select('name', 'slug')->get()))->toBeInstanceOf(HasOptionsComponent::class);
    expect($component->getOptions())->toHaveCount($c->count());
    expect($component->getOptions())->toHaveCount($c->count());
});

it('can chain options from collection using properties', function () {
    $component = new HasOptionsComponent;
    expect($component->fromCollection($c = Product::select('name', 'slug')->get(), 'slug', 'name'))->toBeInstanceOf(HasOptionsComponent::class);
    expect($component->getOptions())->toHaveCount($c->count());
    expect($component->getOptions())->each(function ($option) use ($c) {
        expect($model = $c->where('slug', $option->value->getValue())->first())
            ->toBeInstanceOf(Product::class)
            ->and($option->value->getValue())->toBe($model->slug)
            ->and($option->value->getLabel())->toBe((string) $model->name);
    });
});

it('does not allow for nulls to be set', function () {
    $component = new HasOptionsComponent;
    $component->setOptions(null);
    expect($component->getOptions())->toBeEmpty();
});
