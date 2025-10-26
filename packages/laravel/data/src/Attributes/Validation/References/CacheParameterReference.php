<?php

declare(strict_types=1);

namespace Honed\Data\Attributes\Validation\References;

use Honed\Data\Support\HasRepository;
use Spatie\LaravelData\Support\Validation\References\ExternalReference;

class CacheParameterReference extends HasRepository implements ExternalReference
{
    public function __construct(
        public ?string $cacheKey,
        public mixed $default = null,
        public ?string $driver = null,
    ) {}

    /**
     * Get the value from the cache.
     */
    public function getValue(): mixed
    {
        return $this->getRepository()->get($this->cacheKey, $this->default);
    }
}
