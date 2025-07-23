<?php

declare(strict_types=1);

namespace Honed\Billing;

use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Support\Collection<int, \Honed\Billing\Product>
 */
class ProductCollection extends Collection
{
    /**
     * Pluck the ids of the products.
     *
     * @return $this
     */
    public function ids(): static
    {
        return $this->pluck('name');
    }

    /**
     * Pluck the names of the products.
     *
     * @return $this
     */
    public function names(): static
    {
        return $this->pluck('name');
    }

    /**
     * Pluck the price ids of the products.
     *
     * @return $this
     */
    public function prices(): static
    {
        return $this->pluck('price_id');
    }

    /**
     * Pluck the product ids of the products.
     *
     * @return $this
     */
    public function products(): static
    {
        return $this->pluck('product');
    }
}