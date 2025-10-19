<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Contextual;

use Attribute;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualAttribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class FirstRouteParameter implements ContextualAttribute
{
    /**
     * @param  class-string|null  $type
     */
    public function __construct(
        public ?string $type = null
    ) {}

    /**
     * Resolve the current reseller. Requires reseller feature middleware to be enabled.
     *
     * @return mixed
     */
    public static function resolve(self $attribute, Container $container)
    {
        foreach (($container->make('request')->route()?->parameters() ?? []) as $parameter) {
            if ($attribute->type !== null && ! $parameter instanceof $attribute->type) {
                continue;
            }

            return $parameter;
        }

        return null;
    }
}
