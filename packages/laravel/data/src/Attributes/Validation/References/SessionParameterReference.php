<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation\References;

use Honed\Data\Support\HasSession;
use Spatie\LaravelData\Support\Validation\References\ExternalReference;

class SessionParameterReference extends HasSession implements ExternalReference
{
    public function __construct(
        public ?string $sessionKey,
        public mixed $default = null,
        public ?string $driver = null,
    ) {}

    /**
     * Get the value of the session.
     */
    public function getValue(): mixed
    {
        return $this->getSession()->get($this->sessionKey, $this->default);
    }
}
