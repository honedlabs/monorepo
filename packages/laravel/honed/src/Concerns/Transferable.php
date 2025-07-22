<?php

declare(strict_types=1);

namespace Honed\Honed\Concerns;

use Honed\Honed\Attributes\UseData;
use ReflectionClass;
use Spatie\LaravelData\Data;

/**
 * @property class-string<\Spatie\LaravelData\Data>|null $data
 */
trait Transferable
{
    /**
     * Get the action group instance for the model.
     *
     * @param class-string<\Spatie\LaravelData\Data>|null $data
     */
    public function toData(?string $data = null): Data
    {
        return $this->newData($data);
    }

    /**
     * Create a new action group instance for the model.
     *
     * @param class-string<\Spatie\LaravelData\Data>|null $data
     *
     * @internal
     */
    protected function newData(?string $data = null): ?Data
    {
        /** @var class-string<\Spatie\LaravelData\Data>|null $data */
        $data = match (true) {
            $data !== null => $data,
            isset($this->$data) => $this->$data,
            (bool) $attr = static::getUseDataAttribute() => $attr,
            default => null,
        };

        return $data ? $data::from($this) : null;
    }

    /**
     * Get the actions from the UseBatch class attribute.
     *
     * @return class-string<\Spatie\LaravelData\Data>|null
     *
     * @internal
     */
    protected static function getUseDataAttribute(): ?string
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(UseData::class);

        if ($attributes !== []) {
            $group = $attributes[0]->newInstance();

            return $group->dataClass;
        }

        return null;
    }
}
