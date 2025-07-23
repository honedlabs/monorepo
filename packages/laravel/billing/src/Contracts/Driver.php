<?php

declare(strict_types=1);

namespace Honed\Billing\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface Driver
{
    /**
     * Get the first matching product.
     *
     * @param  array<int,string>  $columns
     * @return mixed
     */
    public function first(array $columns = ['*']);

    /**
     * Get all matching products.
     *
     * @param  array<int,string>  $columns
     * @return mixed
     */
    public function get(array $columns = ['*']);

    /**
     * Scope to the given product.
     *
     * @return $this
     */
    public function whereProduct(mixed $product): static;

    /**
     * Scope to the given products.
     *
     * @param  string|array<int, mixed>|Arrayable<int, mixed>  $products
     * @return $this
     */
    public function whereProducts(string|array|Arrayable $products): static;

    /**
     * Scope to the given product group.
     *
     * @param  string|array<int, string>|Arrayable<int, string>  $group
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
