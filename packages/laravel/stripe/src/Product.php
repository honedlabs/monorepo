<?php

declare(strict_types=1);

namespace Honed\Billing;

use Honed\Billing\Facades\Billing;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Traits\Macroable;

/**
 * @mixin \Honed\Billing\BillingBuilder
 */
class Product implements UrlRoutable
{
    use Macroable;

    /**
     * The name of the product.
     *
     * @var string
     */
    protected $name;

    /**
     * The group of the product.
     *
     * @var string
     */
    protected $group;

    /**
     * The type of the product.
     *
     * @var string
     */
    protected $type;

    /**
     * The price of the product.
     *
     * @var int|float
     */
    protected $price;

    /**
     * The price ID of the product.
     *
     * @var string
     */
    protected $price_id;

    /**
     * The period of the product.
     *
     * @var string
     */
    protected $period;

    public function __construct() {}

    /**
     * Create a new product instance from attributes.
     */
    public static function from(array $attributes): static
    {
        return new self($attributes);
    }

    /**
     * Get the value of the route key.
     */
    public function getRouteKey(): string
    {
        return $this->getName();
    }

    /**
     * Get the route key for the class.
     */
    public function getRouteKeyName(): string
    {
        return 'product';
    }

    /**
     * Retrieve the product for
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->resolveRouteBindingQuery($field, $value)->first();
    }

    /**
     * Retrieve the product for a bound value.
     *
     * @return Contracts\Driver
     */
    public function resolveRouteBindingQuery(mixed $value, string $field)
    {
        return Billing::driver()
            ->whereProduct($value)
            ->tap(function ($query) use ($field) {
                match ($field) {
                    Payment::RECURRING => $query->wherePayment(Payment::RECURRING),
                    Payment::ONCE => $query->wherePayment(Payment::ONCE),
                    default => $query,
                };
            });
    }

    /**
     * Resolve the child route binding.
     *
     * @param  string  $childType
     * @param  mixed  $value
     * @param  string  $field
     * @return mixed
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        return $this->resolveRouteBinding($value, $field);
    }

    /**
     * Get the name of the product.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the group of the product.
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * Get the type of the product.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the price of the product.
     */
    public function getPrice(): int|float
    {
        return $this->price;
    }

    /**
     * Get the price ID of the product.
     */
    public function getPriceId(): string
    {
        return $this->price_id;
    }

    /**
     * Get the period of the product.
     */
    public function getPeriod(): string
    {
        return $this->period;
    }

    /**
     * Determine if the given value represents a null value.
     */
    protected function isNull(mixed $value): bool
    {
        return $value === null || $value === 'null';
    }
}
