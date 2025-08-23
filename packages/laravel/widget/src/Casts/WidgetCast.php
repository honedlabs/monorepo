<?php

declare(strict_types=1);

namespace Honed\Widget\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements \Illuminate\Contracts\Database\Eloquent\CastsAttributes<string|null, string|null>
 */
class WidgetCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  string|null  $value
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  string|null  $value
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return null;
    }
}
