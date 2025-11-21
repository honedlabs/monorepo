<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use BackedEnum;
use Honed\Form\Attributes\Attributes;
use Honed\Form\Attributes\ClassName;
use Honed\Form\Attributes\Hint;
use Honed\Form\Attributes\Label;
use Honed\Form\Attributes\Multiple;
use Honed\Form\Attributes\Placeholder;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Support\DataProperty;

trait Adaptable
{
    /**
     * Get the name of the property.
     */
    public function getNameFromProperty(DataProperty $property): string
    {
        return $property->outputMappedName ?: $property->name;
    }

    /**
     * Get the label for the property.
     */
    public function getLabelFromProperty(DataProperty $property): ?string
    {
        return $property->attributes->first(Label::class)?->getValue();
    }

    /**
     * Get the minimum value for the property.
     */
    public function getMinFromProperty(DataProperty $property): ?int
    {
        $parameter = $property->attributes->first(Min::class)?->parameters()[0];

        return is_int($parameter) ? $parameter : null;
    }

    /**
     * Get the maximum value for the property.
     */
    public function getMaxFromProperty(DataProperty $property): ?int
    {
        $parameter = $property->attributes->first(Max::class)?->parameters()[0];

        return is_int($parameter) ? $parameter : null;
    }

    /**
     * Get the hint for the property.
     */
    public function getHintFromProperty(DataProperty $property): ?string
    {
        return $property->attributes->first(Hint::class)?->getValue();
    }

    /**
     * Get the placeholder for the property.
     */
    public function getPlaceholderFromProperty(DataProperty $property): ?string
    {
        return $property->attributes->first(Placeholder::class)?->getValue();
    }

    /**
     * Get the default value from the property.
     */
    public function getDefaultValueFromProperty(DataProperty $property): mixed
    {
        return $property->defaultValue;
    }

    /**
     * Get the attributes from the property.
     *
     * @return array<string, mixed>
     */
    public function getAttributesFromProperty(DataProperty $property): array
    {
        return $property->attributes->first(Attributes::class)?->getValue() ?? [];
    }

    /**
     * Get the class name from the property.
     */
    public function getClassNameFromProperty(DataProperty $property): ?string
    {
        return $property->attributes->first(ClassName::class)?->getValue();
    }

    /**
     * Get the options from the property.
     *
     * @return array<string, mixed>|class-string<BackedEnum>
     */
    public function getOptionsFromProperty(DataProperty $property): array|string
    {
        if ($attribute = $property->attributes->first(In::class)) {
            // @phpstan-ignore-next-line call.method
            return (fn (): array => $this->values)->call($attribute);
        }

        if (
            $property->type->iterableItemType
            && str_contains($property->type->iterableItemType, '\\')
            && is_a($property->type->iterableItemType, BackedEnum::class, true)
        ) {
            /** @var class-string<BackedEnum> */
            return $property->type->iterableItemType;
        }

        return [];
    }

    /**
     * Determine if the property is required.
     */
    public function isRequiredProperty(DataProperty $property): bool
    {
        return ! $property->type->isNullable
            || $property->attributes->has(Required::class);
    }

    /**
     * Determine if the property is optional.
     */
    public function isOptionalProperty(DataProperty $property): bool
    {
        return $property->type->isOptional;
    }

    /**
     * Determine if the property is multiple.
     *
     * @return true|null
     */
    public function isMultipleProperty(DataProperty $property): ?bool
    {
        return $property->attributes->has(Multiple::class) ?: null;
    }
}
