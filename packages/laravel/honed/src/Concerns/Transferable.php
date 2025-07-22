<?php

declare(strict_types=1);

namespace Honed\Honed\Concerns;

use Honed\Honed\Attributes\UseData;
use ReflectionClass;
use Spatie\LaravelData\Data;

/**
 * @property class-string<Data>|null $data
 */
trait Transferable
{
    /**
     * Get the action group instance for the model.
     *
     * @param  class-string<Data>|null  $data
     */
    public function toData(?string $data = null): Data
    {
        return $this->newData($data);
    }

    /**
     * Get the actions from the UseBatch class attribute.
     *
     * @return class-string<Data>|null
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

    /**
     * Create a new action group instance for the model.
     *
     * @param  class-string<Data>|null  $data
     *
     * @internal
     */
    protected function newData(?string $data = null): ?Data
    {
        if ($data) {
            return $data::from($this);
        }

        if (isset($this->$data)) {
            return $this->$data::from($this);
        }

        if ($attr = static::getUseDataAttribute()) {
            return $attr::from($this);
        }

        return null;
    }
}
