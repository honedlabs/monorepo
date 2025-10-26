<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\User;
use Honed\Data\Attributes\FromFirstRouteParameter;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\LaravelData\Data;

class FirstRouteParameterData extends Data
{
    public function __construct(
        #[FromFirstRouteParameter(Authenticatable::class)]
        public User $user
    ) {}
}
