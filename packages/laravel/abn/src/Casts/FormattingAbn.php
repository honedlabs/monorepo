<?php

declare(strict_types=1);

namespace Honed\Abn\Casts;

use Honed\Abn\AbnValidator;
use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Illuminate\Database\Eloquent\Model;

class FormattingAbn implements CastsInboundAttributes
{
    /**
     * Prepare the given value for storage.
     *
     * @param  string|null  $value
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return AbnValidator::format($value);
    }
}
