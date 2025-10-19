<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation\References;

use Spatie\LaravelData\Support\Validation\References\ExternalReference;

class SessionParameterReference implements ExternalReference
{
    public function __construct(
        public ?string $cacheKey,
        public ?string $driver = null,
    ) {}

    public function getValue(): ?string
    {
        return null;
    }
}
