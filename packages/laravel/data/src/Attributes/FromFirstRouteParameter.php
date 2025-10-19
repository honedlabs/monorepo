<?php

declare(strict_types=1);

namespace Honed\Data\Attributes;

use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\LaravelData\Attributes\InjectsPropertyValue;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\Skipped;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FromFirstRouteParameter implements InjectsPropertyValue
{
    public function __construct(
        public ?string $type = null,
        public bool $replaceWhenPresentInPayload = true
    ) {}

    /**
     * Resolve the first route parameter.
     * 
     * @param array<string, mixed> $properties
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

        $parameter = Arr::first(
            $payload->route()?->parameters() ?? [], 
            fn ($parameter): bool => $this->type ? $parameter instanceof $this->type : true,
        );

        if ($parameter === null) {
            return Skipped::create();
        }

        return $parameter;
    }

    /**
     * Determine if the property should be replaced when present in payload.
     */
    public function shouldBeReplacedWhenPresentInPayload(): bool
    {
        return $this->replaceWhenPresentInPayload;
    }
}
