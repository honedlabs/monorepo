<?php

declare(strict_types=1);

namespace Honed\Stripe;

use App\Models\User;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Traits\Macroable;

/**
 * @mixin \Honed\Stripe\ProductBuilder
 */
class Product implements UrlRoutable
{
    use Macroable;

    /**
     * The ID of the product.
     */
    protected $id;

    public static function find(string $id)
    {
        return static::query()->firstWhere($id);
    }

    public function getRouteKey()
    {
        return $this->id;
    }

    public function getRouteKeyName()
    {
        return 'product';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->resolveRouteBindingQuery($this, $value)->first();
    }

    /**
     * Retrieve the product for a bound value.
     * 
     * @param \Honed\Stripe\ProductBuilder|\Illuminate\Database\Eloquent\Builder $query
     * @return \Honed\Stripe\ProductBuilder
     */
    public function resolveRouteBindingQuery($query, $value)
    {
        return $query->where($value);
    }


    public function resolveChildRouteBinding($childType, $value, $field)
    {
        
    }
}

