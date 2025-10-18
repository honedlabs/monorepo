<?php

declare(strict_types=1);

namespace App\Classes;

use App\Models\Product;
use App\Models\User;
use Honed\Data\Attributes\Contextual\FirstRouteParameter;
use Honed\Data\Attributes\Contextual\SessionParameter;
use Illuminate\Contracts\Auth\Authenticatable;

class GetProduct
{
    public function __construct(
        #[FirstRouteParameter(Product::class)] 
        public ?Product $product
    ) {}

    public function get(): ?Product
    {
        return $this->product;
    }
}