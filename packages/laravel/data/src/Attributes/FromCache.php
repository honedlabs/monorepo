<?php

declare(strict_types=1);

namespace Honed\Data\Attributes;

use Attribute;
use Honed\Data\Support\HasRepository;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\InjectsPropertyValue;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Skipped;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FromCache extends HasRepository implements InjectsPropertyValue
{
    public function __construct(
        public string $cacheKey,
        ?string $driver = null,
        public bool $replaceWhenPresentInPayload = true
    ) {
        $this->driver = $driver;
    }

    /**
     * Resolve the first route parameter.
     *
     * @param  array<string, mixed>  $properties
     * @param CreationContext<*> $creationContext
     */
    public function resolve(
        DataProperty $dataProperty,
        mixed $payload,
        array $properties,
        CreationContext $creationContext
    ): mixed {

        if (! $payload instanceof Request) {
            return Skipped::create();
        }

        return $this->getRepository()->get($this->cacheKey);
    }

    /**
     * Determine if the property should be replaced when present in payload.
     */
    public function shouldBeReplacedWhenPresentInPayload(): bool
    {
        return $this->replaceWhenPresentInPayload;
    }
}
