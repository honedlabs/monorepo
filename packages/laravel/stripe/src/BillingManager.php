<?php

declare(strict_types=1);

namespace Honed\Billing;

class BillingManager
{
    /**
     * The cache of retrieved products.
     * 
     * @var array<string, \Honed\Billing\Billing>
     */
    protected $cache = [];

    public function call()
    {
        return 'hit';
    }
    /**
     * Find a product by name.
     */
    public function find(string $product): ?Billing
    {
        return $this->cache[$product] ??= $this->resolve($product);
    }

    public function driver(string $product)
    {
        // Get a driver

    }

    public function resolve(string $product)
    {
        // Driver

        // Use a driver to resolve the billing.
    }
}