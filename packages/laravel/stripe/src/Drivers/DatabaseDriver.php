<?php

declare(strict_types=1);

namespace Honed\Billing\Drivers;

use Honed\Billing\Concerns\InteractsWithDatabase;
use Honed\Billing\Contracts\Driver;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @mixin \Illuminate\Database\Query\Builder
 */
class DatabaseDriver implements Driver
{
    use ForwardsCalls;
    use InteractsWithDatabase;

    /**
     * The name of the driver.
     *
     * @var string
     */
    protected $name;

    /**
     * The database manager.
     *
     * @var DatabaseManager
     */
    protected $db;

    /**
     * The query.
     *
     * @var Builder|null
     */
    protected $query;

    /**
     * Create a new database driver instance.
     */
    public function __construct(
        string $name,
        DatabaseManager $db
    ) {
        $this->name = $name;
        $this->db = $db;
    }

    /**
     * Dynamically call the query builder.
     *
     * @param  array<int, mixed>  $parameters
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->forwardDecoratedCallTo($this->getQuery(), $method, $parameters);
    }

    /**
     * Get the first matching product.
     *
     * @param  array<int,string>  $columns
     * @return array<string, mixed>|null
     */
    public function first($columns = ['*'])
    {
        return $this->getQuery()->first($columns);
    }

    /**
     * Get all matching products.
     *
     * @param  array<int,string>  $columns
     * @return array<int, array<string, mixed>>
     */
    public function get($columns = ['*'])
    {
        return $this->getQuery()->get($columns);
    }

    /**
     * Scope to the given product.
     *
     * @return $this
     */
    public function whereProduct(mixed $product): static
    {
        return $this->where($this->qualifyColumn('product'), $product);
    }

    /**
     * Scope to the given products.
     *
     * @param  string|array<int, mixed>|Arrayable<int, mixed>  $products
     * @return $this
     */
    public function whereProducts(string|array|Arrayable $products): static
    {
        return $this->whereIn($this->qualifyColumn('product'), $products);
    }

    /**
     * Scope to the given product group.
     *
     * @param  string|array<int, string>|Arrayable<int, string>  $group
     * @return $this
     */
    public function whereGroup(string|array|Arrayable $group): static
    {
        return $this->where($this->qualifyColumn('group'), $group);
    }

    /**
     * Scope to the given product type.
     *
     * @return $this
     */
    public function whereType(string $type): static
    {
        return $this->where($this->qualifyColumn('type'), $type);
    }

    /**
     * Scope to the given payment type.
     *
     * @return $this
     */
    public function wherePayment(string $payment): static
    {
        return $this->where($this->qualifyColumn('payment'), $payment);
    }

    /**
     * Qualify the given column name by the model's table.
     *
     * @param  string|Expression  $column
     * @return string
     */
    public function qualifyColumn($column)
    {
        $column = $column instanceof Expression ? (string) $column->getValue($this->getQuery()->getGrammar()) : $column;

        if (str_contains($column, '.')) {
            return $column;
        }

        return $this->getTable().'.'.$column;
    }

    /**
     * Get the query.
     */
    public function getQuery(): Builder
    {
        return $this->query ??= $this->newQuery();
    }

    /**
     * Create a new billing query.
     */
    protected function newQuery(): Builder
    {
        return $this->connection()
            ->table($this->getTable());
    }

    /**
     * The database connection.
     */
    protected function connection(): Connection
    {
        return $this->db->connection($this->getConnection());
    }
}
