<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Contextual;

use Attribute;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualAttribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class CurrentReseller implements ContextualAttribute
{
    /**
     * Resolve the current reseller. Requires reseller feature middleware to be enabled.
     *
     * @return \Illuminate\Http\Request|null
     */
    public static function resolve(self $attribute, Container $container)
    {
        // return $container->make(FirstRouteParameter::class);
    }
}
