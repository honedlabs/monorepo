<?php

declare(strict_types=1);

use Honed\Form\Form;
use App\Data\ProductData;
use App\Http\Requests\ProductRequest;

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
