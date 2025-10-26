<?php

declare(strict_types=1);

namespace App\Data\Validation;

use App\Models\Product;
use Honed\Data\Attributes\Validation\Authorized;
use Spatie\LaravelData\Data;

class AuthorizedData extends Data
{
    public function __construct(
        #[Authorized('view', Product::class, 'id')]
        public mixed $value
    ) {}
}
