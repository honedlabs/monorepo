<?php

declare(strict_types=1);

use App\Data\ProductData;
use Honed\Form\Exceptions\CannotResolveGenerator;

it('throws exception', function () {
    CannotResolveGenerator::throw(ProductData::class);
})->throws(CannotResolveGenerator::class);
