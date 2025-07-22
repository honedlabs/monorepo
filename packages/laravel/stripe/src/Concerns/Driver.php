<?php

declare(strict_types=1);

namespace Honed\Billing\Concerns;

use Illuminate\Contracts\Support\Arrayable;

interface Driver
{
    /**
     * Scope to the given product.
     * 
     * @return $this
     */
    public function whereProduct(mixed $product): static;

    /**
     * Scope to the given products.
     * 
     * @param string|array<int, mixed>|\Illuminate\Contracts\Support\Arrayable<int, mixed> $products
     * @return $this
     */
    public function whereProducts(mixed|array|Arrayable $products): static;

    /**
     * Scope to the given product group.
     * 
     * @param string|array<int, string>|\Illuminate\Contracts\Support\Arrayable<int, string> $group
     * @return $this
     */
    public function whereGroup(string|array|Arrayable $group): static;

    /**
     * Scope to the given product type.
     * 
     * @return $this
     */
    public function whereType(string $type): static;

    /**
     * Scope to the given payment type.
     * 
     * @return $this
     */
    public function wherePayment(string $payment): static;
}