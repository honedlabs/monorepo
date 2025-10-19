<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Contextual;

use Attribute;
use Honed\Data\Support\HasRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualAttribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class CacheParameter extends HasRepository implements ContextualAttribute
{
    public function __construct(
        public string $cacheKey,
        ?string $driver = null
    ) {
        $this->driver = $driver;
    }

    /**
     * Resolve the cache parameter.
     */
    public static function resolve(self $attribute, Container $container): mixed
    {
        return $attribute->getRepository()->get($attribute->cacheKey);
    }
}
