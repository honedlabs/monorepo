<?php

declare(strict_types=1);

namespace App\Data\Validation;

use App\Models\Product;
use Honed\Data\Attributes\Validation\ForeignId;
use Spatie\LaravelData\Data;

class ForeignIdData extends Data
{
    public function __construct(
        #[ForeignId(Product::class)]
        public int $product_id,
    ) {}
}
