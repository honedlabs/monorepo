<?php

declare(strict_types=1);

namespace Honed\Billing;

use App\Models\User;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Traits\Macroable;

/**
 * @mixin \Honed\Billing\BillingBuilder
 */
class Billing implements UrlRoutable
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
        return 'billing';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->resolveRouteBindingQuery($this, $value)->first();
    }

    /**
     * Retrieve the product for a bound value.
     * 
     * @param \Honed\Billing\BillingBuilder|\Illuminate\Database\Eloquent\Builder $query
     * @return \Honed\Billing\BillingBuilder
     */
    public function resolveRouteBindingQuery($query, $value)
    {
        return $query->where($value);
    }


    public function resolveChildRouteBinding($childType, $value, $field)
    {
        
    }
}

