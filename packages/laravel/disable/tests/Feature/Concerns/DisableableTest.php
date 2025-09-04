<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;

beforeEach(function () {
    $this->freezeTime();

    $this->now = now();

    $this->user = User::factory()->create();

    $this->actingAs($this->user);

    $this->product = Product::factory()->for($this->user)->create();
});

it('checks if the model is disabled from boolean', function () {
    expect($this->product)
        ->isDisabled()->toBeFalse()
        ->isNotDisabled()->toBeTrue()
        ->isEnabled()->toBeTrue()
        ->isNotEnabled()->toBeFalse();

    $this->product->is_disabled = true;

    expect($this->product)
        ->isDisabled()->toBeTrue()
        ->isNotDisabled()->toBeFalse()
        ->isEnabled()->toBeFalse()
        ->isNotEnabled()->toBeTrue();
});

it('checks if the model is disabled from timestamp', function () {
    config([
        'disable.boolean' => false,
    ]);

    expect($this->product)
        ->isDisabled()->toBeFalse()
        ->isNotDisabled()->toBeTrue()
        ->isEnabled()->toBeTrue()
        ->isNotEnabled()->toBeFalse();

    $this->product->disabled_at = $this->now;

    expect($this->product)
        ->isDisabled()->toBeTrue()
        ->isNotDisabled()->toBeFalse()
        ->isEnabled()->toBeFalse()
        ->isNotEnabled()->toBeTrue();
});

it('checks if the model is disabled from user', function () {
    config([
        'disable.boolean' => false,
        'disable.timestamp' => false,
    ]);

    expect($this->product)
        ->isDisabled()->toBeFalse()
        ->isNotDisabled()->toBeTrue()
        ->isEnabled()->toBeTrue()
        ->isNotEnabled()->toBeFalse();

    $this->product->disabled_by = $this->user->id;

    expect($this->product)
        ->isDisabled()->toBeTrue()
        ->isNotDisabled()->toBeFalse()
        ->isEnabled()->toBeFalse()
        ->isNotEnabled()->toBeTrue();
});

it('is disabled by default', function () {
    config([
        'disable.boolean' => false,
        'disable.timestamp' => false,
        'disable.user' => false,
    ]);

    expect($this->product)
        ->isDisabled()->toBeFalse()
        ->isNotDisabled()->toBeTrue()
        ->isEnabled()->toBeTrue()
        ->isNotEnabled()->toBeFalse();

    $this->product->disable()->save();

    expect($this->product)
        ->isDisabled()->toBeFalse()
        ->isNotDisabled()->toBeTrue()
        ->isEnabled()->toBeTrue()
        ->isNotEnabled()->toBeFalse();
});

it('disables the model', function () {
    $this->assertDatabaseHas('products', [
        'id' => $this->product->id,
        'is_disabled' => false,
        'disabled_at' => null,
        'disabled_by' => null,
    ]);

    $this->product->disable()->save();

    $this->assertDatabaseHas('products', [
        'id' => $this->product->id,
        'is_disabled' => true,
        'disabled_at' => $this->now,
        'disabled_by' => $this->user->id,
    ]);

    expect($this->product)
        ->isDisabled()->toBeTrue();
});

it('enables the model', function () {
    $this->product->disable()->save();

    $this->assertDatabaseHas('products', [
        'id' => $this->product->id,
        'is_disabled' => true,
        'disabled_at' => $this->now,
        'disabled_by' => $this->user->id,
    ]);

    $this->product->enable()->save();

    $this->assertDatabaseHas('products', [
        'id' => $this->product->id,
        'is_disabled' => false,
        'disabled_at' => null,
        'disabled_by' => null,
    ]);

    expect($this->product)
        ->isDisabled()->toBeFalse();
});
