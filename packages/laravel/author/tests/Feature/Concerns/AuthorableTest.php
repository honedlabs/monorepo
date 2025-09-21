<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->actingAs($this->user);

    $this->product = Product::factory()->for($this->user)->create();
});

it('has columns', function () {
    expect($this->product)
        ->getCreatedByColumn()->toBe('created_by')
        ->getUpdatedByColumn()->toBe('updated_by')
        ->getQualifiedCreatedByColumn()->toBe("{$this->product->getTable()}.created_by")
        ->getQualifiedUpdatedByColumn()->toBe("{$this->product->getTable()}.updated_by");
});

it('has relationships', function () {
    expect($this->product->createdBy()->is($this->user))->toBeTrue();
    
    expect($this->product->updatedBy()->is($this->user))->toBeTrue();
});

it('sets updated by and created by when creating', function () {
    expect($this->product)
        ->updated_by->toBe($this->user->getKey())
        ->created_by->toBe($this->user->getKey());

    expect($this->product->updatedBy()->is($this->user))->toBeTrue();

    expect($this->product->createdBy()->is($this->user))->toBeTrue();
});

it('sets updated by when updating', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $this->product->update([
        'name' => 'Updated Product',
    ]);

    expect($this->product)
        ->updated_by->toBe($user->getKey());

    expect($this->product->updatedBy()->is($user))->toBeTrue();
});

it('sets created by', function () {
    expect($this->product)
        ->created_by->toBe($this->user->getKey());

    $user = User::factory()->create();

    $this->product->setCreatedBy($user->getKey());

    expect($this->product)
        ->created_by->toBe($user->getKey());

    expect($this->product->createdBy()->is($user))->toBeTrue();
});

it('sets updated by', function () {
    expect($this->product)
        ->updated_by->toBe($this->user->getKey());

    $user = User::factory()->create();

    $this->product->setUpdatedBy($user->getKey());

    expect($this->product)
        ->updated_by->toBe($user->getKey());

    expect($this->product->updatedBy()->is($user))->toBeTrue();
});