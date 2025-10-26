<?php

declare(strict_types=1);

use App\Data\UpdateUserData;
use Honed\Data\Exceptions\PartitionKeyNotSetException;

beforeEach(function () {
    $this->data = UpdateUserData::from([
        'name' => 'Test',
        'products' => [1, 2, 3],
    ]);
});

it('defines partitions', function () {
    expect($this->data->partitions())
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys(['user', 'products']);
});

it('gets partition with inclusion', function () {
    expect($this->data->partition('user'))
        ->toArray()->toEqual([
            'name' => 'Test',
        ]);

    expect($this->data->partition('products'))
        ->toArray()->toEqual([
            'products' => [1, 2, 3],
        ]);
});

it('gets partition with exclusion', function () {
    expect($this->data->partition('user', true))
        ->toArray()->toEqual([
            'products' => [1, 2, 3],
        ]);

    expect($this->data->partition('products', true))
        ->toArray()->toEqual([
            'name' => 'Test',
        ]);
});

it('throws exception when partition key is not set', function () {
    $this->data->partition('test')->toArray();
})->throws(PartitionKeyNotSetException::class);
