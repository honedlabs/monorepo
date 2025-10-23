<?php

declare(strict_types=1);

namespace Honed\Data\Attributes;

use Attribute;
use Honed\Data\Support\HasRequest;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\InjectsPropertyValue;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Skipped;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FromRequestIp extends HasRequest implements InjectsPropertyValue
{
    public function __construct(
        public bool $replaceWhenPresentInPayload = true
    ) {}

    /**
     * Resolve the first route parameter.
     *
     * @param  array<string, mixed>  $properties
     * @param CreationContext<*> $creationContext
     * @return string|Skipped|null
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

        return $this->getRequest()->ip();
    }

    /**
     * Determine if the property should be replaced when present in payload.
     */
    public function shouldBeReplacedWhenPresentInPayload(): bool
    {
        return $this->replaceWhenPresentInPayload;
    }
}
