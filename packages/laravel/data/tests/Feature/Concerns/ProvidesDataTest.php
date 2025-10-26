<?php

declare(strict_types=1);

use App\Models\User;
use App\Data\UserData;
use App\Classes\GlobalCounter;
use App\Data\ProductData;
use App\Data\UpdateUserData;
use App\Models\Product;
use Honed\Data\Concerns\ProvidesData;
use Illuminate\Contracts\Auth\Authenticatable;
use Honed\Data\Exceptions\DataClassNotSetException;

beforeEach(function () {
    $this->class = new class {
        use ProvidesData;
    };
})->only();

afterEach(function () {
    GlobalCounter::reset();
});

it('sets data class', function () {
    $user = User::factory()->create();

    expect($this->class)
        ->getDataClass()->toBeNull()
        ->data(UserData::class)->toBe($this->class)
        ->getDataClass()->toBe(UserData::class)
        ->getData($user)->toBeInstanceOf(UserData::class)
        ->getData(null)->toBeNull();
});

it('throws exception if data class is not set', function () {
    $user = User::factory()->create();

    $this->class->getData($user);
})->throws(DataClassNotSetException::class);

it('provides empty data if no payload is given', function () {
    expect($this->class)
        ->data(UserData::class)->toBe($this->class)
        ->getDataClass()->toBe(UserData::class)
        ->provideData()->toEqual(UserData::empty());

    expect(GlobalCounter::get())->toBe(0);
});

it('provides data if payload is given', function () {
    $user = User::factory()->create();

    expect($this->class)
        ->data(UserData::class)->toBe($this->class)
        ->getDataClass()->toBe(UserData::class)
        ->provideData($user)->toEqual([
            'name' => $user->name,
        ]);

    expect(GlobalCounter::get())->toBe(0);
});

it('provides form data if data is formable', function () {
    $user = User::factory()->create();
    $product = Product::factory()->for($user)->create();

    expect($this->class)
        ->data(ProductData::class)->toBe($this->class)
        ->getDataClass()->toBe(ProductData::class)
        ->provideData($product)->toEqual([
            'user_id' => [
                'name' => $user->name,
            ]
        ]);

    expect(GlobalCounter::get())->toBe(0);
});

it('provides translations', function () {
    $user = User::factory()->create();

    expect($this->class)
        ->data(UpdateUserData::class)->toBe($this->class)
        ->getDataClass()->toBe(UpdateUserData::class)
        ->provideData($user)->toEqual([
            'name' => $user->name,
            'products' => [],
        ]);

    expect(GlobalCounter::get())->toBe(1);
});

it('provides empty data if data is empty', function () {
    expect($this->class)
        ->data(UpdateUserData::class)->toBe($this->class)
        ->getDataClass()->toBe(UpdateUserData::class)
        ->provideData()->toEqual(UpdateUserData::empty());

    expect(GlobalCounter::get())->toBe(1);
});