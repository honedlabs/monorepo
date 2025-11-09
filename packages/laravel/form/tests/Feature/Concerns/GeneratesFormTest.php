<?php

declare(strict_types=1);

use App\Data\ProductData;
use App\Http\Requests\ProductRequest;
use Honed\Form\Form;

beforeEach(function () {
    // dd(ProductData::form());
});

it('generates form from data', function () {
    expect(ProductData::form())
        ->toBeInstanceOf(Form::class);
});

it('generates form from request', function () {
    expect(ProductRequest::form())
        ->toBeInstanceOf(Form::class);
});
