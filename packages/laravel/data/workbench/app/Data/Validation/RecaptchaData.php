<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Recaptcha;
use Spatie\LaravelData\Data;

class RecaptchaData extends Data
{
    public function __construct(
        #[Recaptcha('127.0.0.1')]
        public mixed $value
    ) {}
}
