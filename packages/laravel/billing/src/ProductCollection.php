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
     * @return Collection<int, string|int>
     */
    public function ids(): Collection
    {
        /** @var Collection<int, string|int> */
        return $this->pluck('id');
    }

    /**
     * Pluck the names of the products.
     *
     * @return Collection<int, string>
     */
    public function names(): Collection
    {
        /** @var Collection<int, string> */
        return $this->pluck('name');
    }

    /**
     * Pluck the price ids of the products.
     *
     * @return Collection<int, string>
     */
    public function prices(): Collection
    {
        /** @var Collection<int, string> */
        return $this->pluck('price_id');
    }

    /**
     * Pluck the product ids of the products.
     *
     * @return Collection<int, string|null>
     */
    public function products(): Collection
    {
        /** @var Collection<int, string|null> */
        return $this->pluck('product_id');
    }
}
