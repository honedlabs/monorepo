<?php

declare(strict_types=1);

namespace Honed\Abn\Rules;

use Closure;
use Honed\Abn\AbnValidator;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\App;

class AbnRule implements ValidationRule
{
    /**
     * The translator instance.
     */
    protected Translator $translator;

    /**
     * Create a new Abn rule instance.
     */
    public function __construct()
    {
        $this->translator = App::make(Translator::class);
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (AbnValidator::fails($value)) {
            $fail($this->message($attribute));
        }
    }

    /**
     * Get the validation error message.
     */
    public function message(string $attribute): string
    {
        /** @var string */
        return $this->translator->get('abn::messages.abn', [
            'attribute' => $attribute,
        ]);
    }
}
