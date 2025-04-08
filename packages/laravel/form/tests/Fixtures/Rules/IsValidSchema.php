<?php

declare(strict_types=1);

namespace Honed\Form\Tests\Fixtures\Rules;

use Honed\Form\Contracts\HasTypescript;
use Illuminate\Contracts\Validation\ValidationRule;

class IsValidSchema extends ValidationRule implements HasTypescript
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function typescriptType()
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'price' => [
                'value' => 'number',
                'currency' => 'string | null',
            ]
        ]; 
    }
}
