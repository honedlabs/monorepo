<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Contextual;

use Attribute;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualAttribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class CacheParameter implements ContextualAttribute
{
    public function __construct(
        public string $key,
        public ?string $store = null
    ) {}

    /**
     * Resolve the cache parameter.
     * 
     * @return T
     */
    public static function resolve(self $attribute, Container $container): mixed
    {
        return $container->make('cache')
            ->store($attribute->store)
            ->get($attribute->key);
    }
}
