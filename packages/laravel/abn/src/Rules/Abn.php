<?php

declare(strict_types=1);

namespace Honed\Abn\Rules;

use Closure;
use Honed\Abn\AbnValidator;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\App;

class Abn implements ValidationRule
{
    /**
     * The translator instance.
     */
    protected Translator $translator;

    public function __construct()
    {
        $this->translator = App::make(Translator::class);
    }

    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (AbnValidator::fails($value)) {
            $fail($this->translator->get('abn::messages.abn'), [
                'attribute' => $attribute,
            ]);
        }
    }
}
