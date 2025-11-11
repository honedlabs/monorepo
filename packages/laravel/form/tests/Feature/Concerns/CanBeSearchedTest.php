<?php

declare(strict_types=1);

use App\Models\Product;
use Honed\Form\Data\SearchData;

beforeEach(function () {
    $this->product = Product::factory()->create();
});

it('converts to search data', function () {
    expect($this->product->toSearchData())
        ->toBeInstanceOf(SearchData::class)
        ->toArray()->toEqual([
            'value' => $this->product->getKey(),
            'label' => $this->product->name,
        ]);
});
