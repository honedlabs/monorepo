<?php

declare(strict_types=1);

namespace Honed\Abn\Casts;

use Honed\Abn\AbnValidator;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @implements \Illuminate\Contracts\Database\Eloquent\CastsAttributes<string|null, string|null>
 */
class Abn implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  string|null  $value
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return AbnValidator::format($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  string|null  $value
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return null;
        }

        return Str::replace(' ', '', $value);
    }
}
