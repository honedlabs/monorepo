<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Contextual;

use Attribute;
use Honed\Data\Support\HasSession;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\ContextualAttribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class SessionParameter extends HasSession implements ContextualAttribute
{
    public function __construct(
        public string $sessionKey,
        ?string $driver = null
    ) {
        $this->driver = $driver;
    }

    /**
     * Resolve the session parameter.
     */
    public static function resolve(self $attribute, Container $container): mixed
    {
        return $attribute->getSession()->get($attribute->sessionKey);
    }
}
