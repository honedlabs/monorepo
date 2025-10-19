<?php

declare(strict_types=1);

namespace App\Classes;

use App\Enums\Locale;
use Honed\Data\Attributes\Contextual\FirstRouteParameter;

class GetLocale
{
    public function __construct(
        #[FirstRouteParameter]
        public ?Locale $locale
    ) {}

    public function get(): ?Locale
    {
        return $this->locale;
    }
}
