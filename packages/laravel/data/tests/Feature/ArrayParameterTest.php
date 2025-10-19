<?php

declare(strict_types=1);

use App\Data\ProductData;
use App\Data\ProductUsersData;
use Illuminate\Http\Request;

beforeEach(function () {});

it('handles property', function () {
    $request = Request::create('/', Request::METHOD_POST, [
        'user_id' => [
            'id' => 1,
            'name' => 'Test User',
        ],
    ]);

    expect(ProductData::from($request)->user_id)
        ->toBe(1);
});

it('handles iterable property', function () {
    $request = Request::create('/', Request::METHOD_POST, [
        'user_ids' => [
            [
                'id' => 1,
                'name' => 'Test User',
            ],
            [
                'id' => 2,
                'name' => 'Test User 2',
            ],
        ],
    ]);

    expect(ProductUsersData::from($request)->user_ids)
        ->toBe([1, 2]);
});

it('handles missing key', function () {
    $request = Request::create('/', Request::METHOD_POST, []);

    expect(ProductData::from($request)->user_id)
        ->toBeNull();

    expect(ProductUsersData::from($request)->user_ids)
        ->toBeNull();
});

it('handles missing property', function () {
    $request = Request::create('/', Request::METHOD_POST, [
        'user_id' => [
            [
                'name' => 'Test User',
            ],
        ],
    ]);

    expect(ProductData::from($request)->user_id)->toBeNull();
});

it('handles missing iterable property', function () {
    $request = Request::create('/', Request::METHOD_POST, [
        'user_ids' => [
            [
                'name' => 'Test User',
            ],
            [
                'name' => 'Test User 2',
            ],
        ],
    ]);

    expect(ProductUsersData::from($request)->user_ids)
        ->toBe([]);
});

it('handles malformed iterable property', function () {
    $request = Request::create('/', Request::METHOD_POST, [
        'user_ids' => [
            [
                'id' => 1,
                'name' => 'Test User',
            ],
            [
                'name' => 'Test User 2',
            ],
        ],
    ]);

    expect(ProductUsersData::from($request)->user_ids)
        ->toBe([1]);
});

it('handles non-array property', function () {
    $request = Request::create('/', Request::METHOD_POST, [
        'user_id' => 1,
    ]);

    expect(ProductData::from($request)->user_id)
        ->toBe(1);
});

it('handles non-array iterable property', function () {
    $request = Request::create('/', Request::METHOD_POST, [
        'user_ids' => [
            'key' => 'value',
            'key2' => 'value2',
        ],
    ]);

    expect(ProductUsersData::from($request)->user_ids)
        ->toBe([]);
});
