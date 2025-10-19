<?php

namespace Honed\Data\Attributes\Validation\References;

use Spatie\LaravelData\Exceptions\CannotResolveRouteParameterReference;
use Spatie\LaravelData\Support\Validation\References\ExternalReference;

class SessionParameterReference implements ExternalReference
{
    public function __construct(
        public ?string $cacheKey,
        public ?string $driver = null,
    ) { }

    public function getValue(): ?string
    {
        return null;
    }
}
