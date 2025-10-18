<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Contextual;

use Attribute;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualAttribute;
use Illuminate\Database\Eloquent\Model;

#[Attribute(Attribute::TARGET_PARAMETER)]
class FirstRouteParameter implements ContextualAttribute
{
    public function __construct(
        public bool $acceptsOnlyModels = true
    ) {}

    /**
     * Resolve the current reseller. Requires reseller feature middleware to be enabled.
     *
     * @return mixed
     */
    public static function resolve(self $attribute, Container $container)
    {
        foreach ($container->make('request')->route()->parameters() as $parameter) {
            if ($attribute->acceptsOnlyModels && ! $parameter instanceof Model) {
                continue;
            }

            return $parameter;
        }
    }
}
