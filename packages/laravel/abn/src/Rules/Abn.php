<?php

namespace Honed\Abn\Rules;

use Closure;
use Honed\Abn\AbnValidator;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\ValidationRule;

class Abn implements ValidationRule
{
    /**
     * The translator instance.
     * 
     * @var \Illuminate\Contracts\Translation\Translator
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
