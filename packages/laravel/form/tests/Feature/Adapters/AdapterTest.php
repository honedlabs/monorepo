<?php

declare(strict_types=1);

use App\Data\ProductData;
use Honed\Form\Adapters\DefaultAdapter;
use Spatie\LaravelData\Support\DataConfig;

beforeEach(function () {
    $this->converter = new DefaultAdapter();

    $this->dataClass = app(DataConfig::class)->getDataClass(ProductData::class);
});

it('converts data property to component', function () {
    // dd($this->dataClass);
});