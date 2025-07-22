<?php

declare(strict_types=1);

namespace Honed\Billing;

use App\Models\User;
use Honed\Billing\Facades\Billing as Billing;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;

/**
 * @mixin \Honed\Billing\BillingBuilder
 */
class Product implements UrlRoutable
{
    use Macroable;

    /**
     * The ID of the product.
     * 
     * @var string
     */
    protected $id;

    public static function find(string $id)
    {
        return static::query()->firstWhere($id);
    }

    /**
     * Get the value of the route key.
     */
    public function getRouteKey(): string
    {
        return $this->id;
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
     * @return \Honed\Billing\Contracts\Driver
     */
    public function resolveRouteBindingQuery(mixed $value, string $field)
    {
        return Billing::driver()
            ->whereProduct($value);
            // ->tap(function ($query) use ($field) {
            //     match ($field) {
            //         Payment::RECURRING => $query->wherePayment(Payment::RECURRING),
            //         Payment::ONCE => $query->wherePayment(Payment::ONCE),
            //         default => $query,
            //     };
            // });
    }


    public function resolveChildRouteBinding($childType, $value, $field)
    {
        
    }

    public function getName()
    {

    }

    public function getGroup()
    {

    }

    public function getType()
    {

    }

    public function getPrice()
    {

    }

    public function getPriceId()
    {

    }

    public function getPeriod()
    {

    }
}

