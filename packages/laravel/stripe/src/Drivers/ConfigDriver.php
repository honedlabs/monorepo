<?php

declare(strict_types=1);

namespace Honed\Billing\Drivers;

use Closure;
use Honed\Billing\Contracts\Driver;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class ConfigDriver implements Driver
{
    /**
     * The name of the driver.
     * 
     * @var string
     */
    protected $name;

    /**
     * The config instance.
     * 
     * @var array<string, mixed>
     */
    protected $config;

    /**
     * The where constraints for the query.
     *
     * @var array<int, \Closure(array<string, mixed>): bool>
     */
    protected $wheres;

    /**
     * Create a new config driver instance.
     * 
     * @param array<string, mixed> $config
     */
    public function __construct(
        string $name,
        array $config
    ) {
        $this->name = $name;
        $this->config = $config;
    }

    /**
     * Get the first matching product.
     * 
     * @param array<int,string> $columns
     * @return array<string, mixed>|null
     */
    public function first($columns = ['*'])
    {
        $product = Arr::first($this->resolve());

        if (is_null($product)) {
            return null;
        }

        return $this->select($product, $columns);
    }

    /**
     * Get all matching products.
     * 
     * @param array<int,string> $columns
     * @return array<int, array<string, mixed>>
     */
    public function get($columns = ['*'])
    {
        $products = $this->resolve();

        return Arr::map(
            $products, 
            fn (array $product) => $this->select($product, $columns)
        );
    }

    /**
     * Scope to the given callback.
     * 
     * @param \Closure(array<string, mixed>): bool $callback
     * @return $this
     */
    public function where(Closure $callback): static
    {
        $this->wheres[] = $callback;

        return $this;
    }

    /**
     * Scope to the given column.
     * 
     * @return $this
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

    /**
     * Scope a column to the given values.
     * 
     * @param array<int, mixed> $values
     * @return $this
     */
    public function whereIn(string $key, array $values): static
    {
        return $this->where(static fn (array $product) => in_array($product[$key], Arr::wrap($values)));
    }

    /**
     * Scope to the given product.
     * 
     * @return $this
     */
    public function whereProduct(mixed $product): static
    {
        return $this->whereColumn('name', $product);
    }

    /**
     * Scope to the given products.
     * 
     * @param string|array<int, mixed>|\Illuminate\Contracts\Support\Arrayable<int, mixed> $products
     * @return $this
     */
    public function whereProducts(string|array|Arrayable $products): static
    {
        return $this->whereIn('name', $products);
    }

    /**
     * Scope to the given group.
     * 
     * @param string|array<int, string>|\Illuminate\Contracts\Support\Arrayable<int, string> $group
     * @return $this
     */
    public function whereGroup(string|array|Arrayable $group): static
    {
        return $this->whereIn('group', $group);
    }

    /**
     * Scope to the given type.
     * 
     * @param string $type
     * @return $this
     */
    public function whereType(string $type): static
    {
        return $this->whereColumn('type', $type);
    }

    /**
     * Scope to the given payment.
     * 
     * @param string $payment
     * @return $this
     */
    public function wherePayment(string $payment): static
    {
        return $this->whereColumn('payment', $payment);
    }

    /**
     * Select the columns from the products.
     * 
     * @param array<string, array<string, mixed>> $products
     * @param array<int,string> $columns
     * @return array<int, array<string, mixed>>
     */
    protected function select(array $products, array $columns = ['*']): array
    {
        if ($columns === ['*']) {
            return $products;
        }

        return Arr::select($products, $columns);
    }

    /**
     * Resolve the query.
     * 
     * @return array<string, array<string, mixed>>
     */
    protected function resolve(): array
    {
        $config = $this->getConfig();

        foreach ($this->wheres as $where) {
            $config = Arr::where($config, $where);
        }

        return $config;
    }

    /**
     * Get the products from the config.
     * 
     * @return array<string, array<string, mixed>>
     */
    protected function getConfig(): array
    {
        /** @var array<string, array<string, mixed>> */
        return $this->config['products'] ?? [];
    }
}