<?php

declare(strict_types=1);

namespace Honed\Billing\Drivers;

use Honed\Billing\Concerns\Driver;
use Honed\Billing\Concerns\InteractsWithDatabase;
use Honed\Billing\Payment;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Query\Builder;

class DatabaseDriver extends Builder implements Driver
{
    use InteractsWithDatabase;

    /**
     * Scope to the given product.
     * 
     * @return $this
     */
    public function whereProduct(mixed $product): static
    {
        return $this->where('product', $product);
    }

    /**
     * Scope to the given products.
     * 
     * @param string|array<int, mixed>|\Illuminate\Contracts\Support\Arrayable<int, mixed> $products
     * @return $this
     */

    public function whereProducts(mixed|array|Arrayable $products): static
    {
        return $this->whereIn('product', $products);
    }

    /**
     * Scope to the given product group.
     * 
     * @param string|array<int, string>|\Illuminate\Contracts\Support\Arrayable<int, string> $group
     * @return $this
     */
    public function whereGroup(string|array|Arrayable $group): static
    {
        return $this->where('group', $group);
    }

    /**
     * Scope to the given product type.
     * 
     * @return $this
     */
    public function whereType(string $type): static
    {
        return $this->where('type', $type);
    }

    /**
     * Scope to the given payment type.
     * 
     * @return $this
     */
    public function wherePayment(string $payment): static
    {
        return $this->where('payment', $payment);
    }

    /**
     * Qualify the given column name by the model's table.
     *
     * @param  string|\Illuminate\Contracts\Database\Query\Expression  $column
     * @return string
     */
    public function qualifyColumn($column)
    {
        $column = $column instanceof Expression ? $column->getValue($this->getGrammar()) : $column;

        if (str_contains($column, '.')) {
            return $column;
        }

        return $this->getTable().'.'.$column;
    }
}