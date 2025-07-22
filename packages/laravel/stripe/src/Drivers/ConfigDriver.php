<?php

declare(strict_types=1);

namespace Honed\Billing\Drivers;

use Closure;
use Honed\Billing\Concerns\Driver;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class ConfigDriver implements Driver
{
    /**
     * The where constraints for the query.
     *
     * @var array<int, \Closure(array<string, mixed>): bool>
     */
    protected $wheres;

    public function where(Closure $callback): static
    {
        $this->wheres[] = $callback;

        return $this;
    }

    /**
     * Scope to the given column.
     */
    public function whereColumn(string $key, mixed $value, string $operator = '='): static
    {
        return $this->where(static fn (array $product) => match ($operator) {
            '=' => $product[$key] === $value,
            '!=' => $product[$key] !== $value,
            '>' => $product[$key] > $value,
            '>=' => $product[$key] >= $value,
            '<' => $product[$key] < $value,
            '<=' => $product[$key] <= $value,
            default => throw new \InvalidArgumentException(
                "An unsupported operator: {$operator} was supplied."
            )
        });
    }

    public function whereIn(string $key, array $values): static
    {
        return $this->where(static fn (array $product) => in_array($product[$key], Arr::wrap($values)));
    }

    public function whereProduct(mixed $product): static
    {
        return $this->whereColumn('name', $product);
    }

    public function whereProducts(mixed|array|Arrayable $products): static
    {
        return $this->whereIn('name', $products);
    }

    public function whereGroup(string|array|Arrayable $group): static
    {
        return $this->whereIn('group', $group);
    }

    public function whereType(string $type): static
    {
        return $this->whereColumn('type', $type);
    }

    public function wherePayment(string $payment): static
    {
        return $this->whereColumn('payment', $payment);
    }

    /**
     * Get the products from the config.
     * 
     * @return array<string, array<string, mixed>>
     */
    protected function getConfig(): array
    {
        /** @var array<string, array<string, mixed>> */
        return config('billing.products', []);
    }


}