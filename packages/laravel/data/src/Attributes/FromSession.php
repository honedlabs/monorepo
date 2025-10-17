<?php

declare(strict_types=1);

namespace Honed\Data\Attributes;

use Attribute;
use Spatie\LaravelData\Attributes\InjectsPropertyValue;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FromSession implements InjectsPropertyValue
{
    public function __construct(
        public string $key,
        public bool $replaceWhenPresentInPayload = true
    ) {}

    public function resolve(
        DataProperty $dataProperty,
        mixed $payload,
        array $properties,
        CreationContext $creationContext
    ): mixed {
        return app()->session($this->key);
    }

    public function shouldBeReplacedWhenPresentInPayload(): bool
    {
        return $this->replaceWhenPresentInPayload;
    }
}
