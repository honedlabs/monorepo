<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Contextual;

use Attribute;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualAttribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

/**
 * @template T
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class SessionParameter implements ContextualAttribute
{
    public function __construct(
        public string $sessionKey,
        public ?string $driver = null
    ) {}

    /**
     * Resolve the session parameter.
     * 
     * @return T
     */
    public static function resolve(self $attribute, Container $container): mixed
    {
        return $container->make('session')
            ->driver($attribute->driver)
            ->get($attribute->sessionKey);
    }
}
