<?php

namespace Honed\Abn\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Abn implements ValidationRule
{
    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
}
