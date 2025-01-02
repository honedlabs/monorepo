<?php

declare(strict_types=1);

use Honed\Core\Options\Option;
use Honed\Core\Tests\Stubs\Status;
use Illuminate\Support\Collection;
use Honed\Core\Tests\Stubs\Product;
use Honed\Core\Options\Concerns\HasOptions;

class HasOptionsComponent
{
    use HasOptions;
}

beforeEach(function () {
    $this->component = new HasOptionsComponent;
    Product::all()->each->delete();
});

it('has no options by default', function () {
    expect($this->component)
        ->getOptions()->toBeEmpty()
        ->hasOptions()->toBeFalse();
});

it('adds options', function () {
    $this->component->addOption(Option::make('value', 'Label'));
    expect($this->component)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(1)
        ->getOptions()->{0}->scoped(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('value')
                ->getLabel()->toBe('Label')
        );
});

it('sets options', function () {
    $this->component->setOptions([Option::make('value', 'Label')]);
    expect($this->component)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(1)
        ->getOptions()->{0}->scoped(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('value')
                ->getLabel()->toBe('Label')
        );
});

it('rejects null values', function () {
    $this->component->setOptions([Option::make('value', 'Label')]);
    $this->component->setOptions(null);
    expect($this->component)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(1)
        ->getOptions()->{0}->scoped(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('value')
                ->getLabel()->toBe('Label')
        );
});

it('sets options from list', function () {
    $this->component->setOptions(['value']);
    expect($this->component)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(1)
        ->getOptions()->{0}->scoped(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('value')
                ->getLabel()->toBe('Value')
        );
});

it('sets options from associative pair', function () {
    $this->component->setOptions(['value' => 'Label']);
    expect($this->component)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(1)
        ->getOptions()->{0}->scoped(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('value')
                ->getLabel()->toBe('Label')
        );
});

it('can collect options', function () {
    $this->component->setOptions([Option::make('value', 'Label')]);
    expect($this->component->collectOptions())->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->scoped(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('value')
                ->getLabel()->toBe('Label')
        );
});

it('has shorthand `fromEnum` with defaults', function () {
    expect($this->component->fromEnum(Status::class))->toBeInstanceOf(HasOptionsComponent::class)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(\count(Status::cases()))
        ->getOptions()->sequence(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe(Status::Available->value)
                ->getLabel()->toBe(Status::Available->name),
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe(Status::Unavailable->value)
                ->getLabel()->toBe(Status::Unavailable->name),
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe(Status::ComingSoon->value)
                ->getLabel()->toBe(Status::ComingSoon->name),
        );
});

it('has shorthand `fromEnum` with methods', function () {
    expect($this->component->fromEnum(Status::class, label: 'label'))->toBeInstanceOf(HasOptionsComponent::class)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(\count(Status::cases()))
        ->getOptions()->sequence(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe(Status::Available->value)
                ->getLabel()->toBe(Status::Available->label()),
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe(Status::Unavailable->value)
                ->getLabel()->toBe(Status::Unavailable->label()),
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe(Status::ComingSoon->value)
                ->getLabel()->toBe(Status::ComingSoon->label()),
        );
});

it('has shorthand `fromModel` with defaults', function () {
    $a = product();
    $b = product();

    expect($this->component->fromModel(Product::class))->toBeInstanceOf(HasOptionsComponent::class)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(2)
        ->getOptions()->sequence(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe($a->getKey())
                ->getLabel()->toBe((string) $a->getKey()),
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe($b->getKey())
                ->getLabel()->toBe((string) $b->getKey()),
        );
});

it('has shorthand `fromModel` with properties', function () {
    $a = product();
    $b = product();

    expect($this->component->fromModel(Product::class, 'public_id', 'name'))->toBeInstanceOf(HasOptionsComponent::class)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(2)
        ->getOptions()->sequence(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe($a->public_id->serialize())
                ->getLabel()->toBe((string) $a->name),
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe($b->public_id->serialize())
                ->getLabel()->toBe((string) $b->name),
        );
});

it('has shorthand `fromCollection` with defaults', function () {
    $collection = collect([1, 2, 3]);
    expect($this->component->fromCollection($collection))->toBeInstanceOf(HasOptionsComponent::class)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount($collection->count())
        ->getOptions()->sequence(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe(1)
                ->getLabel()->toBe((string) 1),
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe(2)
                ->getLabel()->toBe((string) 2),
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe(3)
                ->getLabel()->toBe((string) 3),
        );
});

it('has shorthand `fromCollection` with properties', function () {
    $a = product();
    $b = product();

    $products = Product::query()
        ->select('public_id', 'name')
        ->orderBy('id')
        ->get();

    expect($this->component->fromCollection($products, 'public_id', 'name'))->toBeInstanceOf(HasOptionsComponent::class)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(2)
        ->getOptions()->sequence(
            fn ($option) => 
            $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe($a->public_id->serialize())
                ->getLabel()->toBe((string) $a->name),
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe($b->public_id->serialize())
                ->getLabel()->toBe((string) $b->name),
        );
});

it('chains options as array', function () {
    expect($this->component->options(['value' => 'Label']))->toBeInstanceOf(HasOptionsComponent::class)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(1)
        ->getOptions()->{0}->scoped(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('value')
                ->getLabel()->toBe('Label')
        );
});

it('chains options as option', function () {
    expect($this->component->options(Option::make('value', 'Label')))->toBeInstanceOf(HasOptionsComponent::class)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(1)
        ->getOptions()->{0}->scoped(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('value')
                ->getLabel()->toBe('Label')
        );
});

it('chains options as collection', function () {
    expect($this->component->options(collect([Option::make('value', 'Label')])))->toBeInstanceOf(HasOptionsComponent::class)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(1)
        ->getOptions()->{0}->scoped(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('value')
                ->getLabel()->toBe('Label')
        );
});

it('chains options from spread', function () {
    $a = Option::make('a', 'Label A');
    $b = Option::make('b', 'Label B');
    $c = Option::make('c', 'Label C');
    expect($this->component->options($a, $b, $c))->toBeInstanceOf(HasOptionsComponent::class)
        ->hasOptions()->toBeTrue()
        ->getOptions()->toHaveCount(3)
        ->getOptions()->sequence(
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('a')
                ->getLabel()->toBe('Label A'),
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('b')
                ->getLabel()->toBe('Label B'),
            fn ($option) => $option->toBeInstanceOf(Option::class)
                ->getValue()->toBe('c')
                ->getLabel()->toBe('Label C'),
        );
});
