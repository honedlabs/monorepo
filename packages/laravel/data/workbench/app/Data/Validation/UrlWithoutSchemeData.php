<?php

declare(strict_types=1);

namespace App\Data\Validation;

use Honed\Data\Attributes\Validation\Scalar;
use Honed\Data\Attributes\Validation\UrlWithoutScheme;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Data;

class UrlWithoutSchemeData extends Data
{
    public function __construct(
        #[Nullable, UrlWithoutScheme]
        public mixed $test = null
    ) {}
}
