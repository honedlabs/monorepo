<?php

declare(strict_types=1);

use App\Data\ProductData;

beforeEach(function () {
    dd(ProductData::form());
})->only();

it('generates store form', function () {
});
