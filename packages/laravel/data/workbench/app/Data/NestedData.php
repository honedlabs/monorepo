<?php

declare(strict_types=1);

namespace App\Data;

use Honed\Data\Data\FormData;

class NestedData extends FormData
{
    public ProductData $product;
}
