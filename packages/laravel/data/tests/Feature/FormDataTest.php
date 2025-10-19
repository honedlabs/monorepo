<?php

declare(strict_types=1);

use App\Data\ProductData;
use Illuminate\Http\Request;

beforeEach(function () {});

it('tests', function () {
    $request = Request::create('/', Request::METHOD_POST, [
        'name' => 'Test',
        'user_id' => [
            'id' => 1,
            'name' => 'Test User',
        ],
    ]);

    // dd(ProductData::from($request));
    expect(true)->toBeTrue();
});
