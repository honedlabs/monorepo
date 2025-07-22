<?php

declare(strict_types=1);

namespace Honed\Stripe;

class Subscription extends Product
{
    public function resolveRouteBinding($value, $field = null)
    {
        return $this
            ->resolveRouteBindingQuery($this, $value)
            ->whereRecurring()
            ->first();
    }
}