<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasOptions;
use Honed\Core\Option;
use Honed\Core\Tests\Stubs\Product;
use Honed\Core\Tests\Stubs\Status;

class OptionsTest
{
    use HasOptions;
}

beforeEach(function () {
    $this->test = new OptionsTest;
    Product::all()->each->delete();
});

it('is empty by default', function () {
    expect($this->test)
        ->options()->toBeEmpty()
        ->hasOptions()->toBeFalse();
});

it('sets options', function () {
    expect($this->test->options(Option::make('value', 'Label'), Option::make('value2', 'Label2')))
        ->toBeInstanceOf(OptionsTest::class)
        ->hasOptions()->toBeTrue()
        ->options()->scoped(fn ($options) => $options
            ->toBeCollection()
            ->toHaveCount(2)
            ->sequence(
                fn ($option) => $option->toBeInstanceOf(Option::class)
                    ->value()->toBe('value')
                    ->label()->toBe('Label'),
                fn ($option) => $option->toBeInstanceOf(Option::class)
                    ->value()->toBe('value2')
                    ->label()->toBe('Label2'),
            )
        );
});

it('sets enums with defaults', function () {
    expect($this->test->options(Status::class))
        ->toBeInstanceOf(OptionsTest::class)
        ->hasOptions()->toBeTrue()
        ->options()->scoped(fn ($options) => $options
            ->toBeCollection()
            ->toHaveCount(3)
            ->sequence(
                fn ($option) => $option->toBeInstanceOf(Option::class)
                    ->value()->toBe(Status::Available->value)
                    ->label()->toBe(Status::Available->name),
                fn ($option) => $option->toBeInstanceOf(Option::class)
                    ->value()->toBe(Status::Unavailable->value)
                    ->label()->toBe(Status::Unavailable->name),
                fn ($option) => $option->toBeInstanceOf(Option::class)
                    ->value()->toBe(Status::ComingSoon->value)
                    ->label()->toBe(Status::ComingSoon->name),
            )
        );
});

it('sets enums with methods', function () {
    expect($this->test->options(Status::class, null, 'label'))
        ->toBeInstanceOf(OptionsTest::class)
        ->hasOptions()->toBeTrue()
        ->options()->scoped(fn ($options) => $options
            ->toBeCollection()
            ->toHaveCount(3)
            ->sequence(
                fn ($option) => $option->toBeInstanceOf(Option::class)
                    ->value()->toBe(Status::Available->value)
                    ->label()->toBe(Status::Available->label()),
                fn ($option) => $option->toBeInstanceOf(Option::class)
                    ->value()->toBe(Status::Unavailable->value)
                    ->label()->toBe(Status::Unavailable->label()),
                fn ($option) => $option->toBeInstanceOf(Option::class)
                    ->value()->toBe(Status::ComingSoon->value)
                    ->label()->toBe(Status::ComingSoon->label()),
            )
        );
});

it('sets from model', function () {
    $product = product();

    expect($this->test->options(Product::class, 'id', 'name'))
        ->toBeInstanceOf(OptionsTest::class)
        ->hasOptions()->toBeTrue()
        ->options()->scoped(fn ($options) => $options
            ->toBeCollection()
            ->toHaveCount(1)
            ->first()->scoped(fn ($option) => $option
                ->toBeInstanceOf(Option::class)
                ->value()->toBe($product->id)
                ->label()->toBe($product->name)
            )
        );
});
