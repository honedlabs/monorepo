<?php

declare(strict_types=1);

namespace App\Classes;

use App\Models\User;
use Honed\Data\Attributes\Contextual\FirstRouteParameter;
use Honed\Data\Attributes\Contextual\SessionParameter;
use Illuminate\Contracts\Auth\Authenticatable;

class PrimitiveClass
{
    public function __construct(
        #[FirstRouteParameter] 
        public string $locale
    ) {}

    public function get(): string
    {
        return $this->locale;
    }
}