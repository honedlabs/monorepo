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
        ->getDeletedByColumn()->toBe('deleted_by')
        ->getQualifiedDeletedByColumn()->toBe("{$this->product->getTable()}.deleted_by");
});

it('has relationship', function () {
    expect($this->product)
        ->deletedBy()->toBeInstanceOf(BelongsTo::class);
});

it('sets deleted by when deleting', function () {
    expect($this->product)
        ->deleted_by->toBeNull();

    $this->product->delete();

    expect($this->product)
        ->deleted_by->toBe($this->user->getKey());

    expect($this->product->deletedBy()->is($this->user))->toBeTrue();
});

it('sets deleted by', function () {
    expect($this->product)
        ->deleted_by->toBeNull();

    $this->product->setDeletedBy($this->user->getKey());

    expect($this->product)
        ->deleted_by->toBe($this->user->getKey());

    expect($this->product->deletedBy()->is($this->user))->toBeTrue();
});
