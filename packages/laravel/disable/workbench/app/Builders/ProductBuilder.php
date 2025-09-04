<?php

declare(strict_types=1);

namespace App\Builders;

use Honed\Disable\Concerns\QueriesDisableable;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModel of \App\Models\Product
 * 
 * @extends \Illuminate\Database\Eloquent\Builder<TModel>
 */
class ProductBuilder extends Builder
{
    use QueriesDisableable;
}