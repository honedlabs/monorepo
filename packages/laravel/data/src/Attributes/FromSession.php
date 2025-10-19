<?php

declare(strict_types=1);

namespace Honed\Data\Attributes;

use Attribute;
use Honed\Data\Support\HasSession;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\InjectsPropertyValue;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Skipped;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FromSession extends HasSession implements InjectsPropertyValue
{
    public function __construct(
        public string $sessionKey,
        ?string $driver = null,
        public bool $replaceWhenPresentInPayload = true
    ) {
        $this->driver = $driver;
    }

    /**
     * Resolve the session property value.
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

        return $this->getSession()->get($this->sessionKey);
    }

    /**
     * Determine if the property should be replaced when present in payload.
     */
    public function shouldBeReplacedWhenPresentInPayload(): bool
    {
        return $this->replaceWhenPresentInPayload;
    }
}
