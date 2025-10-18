<?php

declare(strict_types=1);

namespace App\Classes;

use App\Enums\Locale;
use App\Models\User;
use Honed\Data\Attributes\Contextual\FirstRouteParameter;
use Honed\Data\Attributes\Contextual\SessionParameter;
use Illuminate\Contracts\Auth\Authenticatable;

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