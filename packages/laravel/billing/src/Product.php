<?php

declare(strict_types=1);

namespace Honed\Billing;

use JsonSerializable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Honed\Billing\Facades\Billing;
use Honed\Billing\Drivers\Decorator;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;

/**
 * @implements \Illuminate\Contracts\Support\Arrayable<string, mixed>
 */
class Product implements Arrayable, JsonSerializable, UrlRoutable
{
    use Macroable;

    /**
     * The identifier of the product.
     *
     * @var string
     */
    protected $id;

    /**
     * The name of the product.
     *
     * @var string
     */
    protected $name;

    /**
     * The group of the product.
     *
     * @var string|null
     */
    protected $group;

    /**
     * The type of the product.
     *
     * @var string|null
     */
    protected $type;

    /**
     * The price of the product.
     *
     * @var int|float|null
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
     * @var string|null
     */
    protected $period;

    /**
     * The product id.
     *
     * @var string|null
     */
    protected $product_id;

    /**
     * Create a new product instance from attributes.
     *
     * @param  array<string, mixed>  $attributes
     */
    public static function from(array $attributes): static
    {
        return resolve(static::class)
            ->id(Arr::get($attributes, 'id'))
            ->name(Arr::get($attributes, 'name'))
            ->group(Arr::get($attributes, 'group'))
            ->type(Arr::get($attributes, 'type'))
            ->price(Arr::get($attributes, 'price'))
            ->priceId(Arr::get($attributes, 'price_id'))
            ->period(Arr::get($attributes, 'period'))
            ->productId(Arr::get($attributes, 'product_id'));
    }

    /**
     * Set the identifier of the product.
     *
     * @return $this
     */
    public function id(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the identifier of the product.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the name of the product.
     *
     * @return $this
     */
    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the name of the product.
     */
    public function getName(): string
    {
        return $this->name ?? $this->guessName();
    }

    /**
     * Set the group of the product.
     *
     * @return $this
     */
    public function group(?string $group): static
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get the group of the product.
     */
    public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * Set the type of the product.
     *
     * @return $this
     */
    public function type(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the type of the product.
     */
    public function getType(): string
    {
        if ($this->isNull($this->type)) {
            /** @var string */
            return config('billing.type', Payment::RECURRING);
        }

        /** @var string */
        return $this->type;
    }

    /**
     * Set the price of the product.
     *
     * @return $this
     */
    public function price(int|float|null $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the price of the product.
     */
    public function getPrice(): int|float|null
    {
        return $this->price;
    }

    /**
     * Get the formatted price of the product.
     */
    public function getFormattedPrice(): ?string
    {
        if (is_null($this->price)) {
            return null;
        }

        $price = is_float($this->price)
            ? (int) round($this->price * 100, 2)
            : $this->price;

        return Cashier::formatAmount($price);
    }

    /**
     * Set the price ID of the product.
     *
     * @return $this
     */
    public function priceId(string $price_id): static
    {
        $this->price_id = $price_id;

        return $this;
    }

    /**
     * Get the price ID of the product.
     */
    public function getPriceId(): string
    {
        return $this->price_id;
    }

    /**
     * Set the period of the product.
     *
     * @return $this
     */
    public function period(?string $period): static
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get the period of the product.
     */
    public function getPeriod(): string
    {
        if ($this->isNull($this->period)) {
            /** @var string */
            return config('billing.period', Period::MONTHLY);
        }

        /** @var string */
        return $this->period;
    }

    /**
     * Set the product id of the product.
     *
     * @return $this
     */
    public function productId(?string $product_id): static
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the product id.
     */
    public function getProductId(): ?string
    {
        return $this->product_id;
    }

    /**
     * Get the value of the route key.
     */
    public function getRouteKey(): string
    {
        return $this->getId();
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
     *
     * @param  mixed  $value
     * @param  string|null  $field
     */
    public function resolveRouteBinding($value, $field = null): ?self
    {
        return $this->resolveRouteBindingQuery($value, $field)->first();
    }

    /**
     * Retrieve the product for a bound value.
     */
    public function resolveRouteBindingQuery(mixed $value, ?string $field = null): Decorator
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
     * Get the instance as an array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'period' => $this->getPeriod(),
            'price' => $this->getFormattedPrice(),
        ];
    }

    // /**
    //  * Convert the object to its JSON representation.
    //  */
    // public function toJson($options = 0)
    // {
    //     return json_encode($this->toArray(), $options);
    // }

    /**
     * Specify which fields should be serialized to JSON.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Guess the name of the product using the identifier.
     * 
     * @return string
     */
    protected function guessName(): string
    {
        return Str::of($this->getId())
            ->snake()
            ->ucfirst()
            ->replace('_', ' ')
            ->value();
    }

    /**
     * Determine if the given value represents a null value.
     */
    protected function isNull(mixed $value): bool
    {
        return $value === null || $value === 'null';
    }
}
