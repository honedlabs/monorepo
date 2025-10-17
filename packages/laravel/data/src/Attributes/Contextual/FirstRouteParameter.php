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
     * Create a new class instance.
     */
    public function __construct() { }

    /**
     * Resolve the current reseller. Requires reseller feature middleware to be enabled.
     *
     * @param  self  $attribute
     * @param  \Illuminate\Contracts\Container\Container  $container
     * @return \Illuminate\Http\Request|null
     */
    public static function resolve(self $attribute, Container $container)
    {
        // return $container->make(FirstRouteParameter::class);
    }
}
