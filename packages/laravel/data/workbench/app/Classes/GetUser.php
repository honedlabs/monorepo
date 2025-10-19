<?php

declare(strict_types=1);

namespace App\Classes;

use App\Models\User;
use Honed\Data\Attributes\Contextual\FirstRouteParameter;
use Illuminate\Contracts\Auth\Authenticatable;

class GetUser
{
    public function __construct(
        #[FirstRouteParameter(Authenticatable::class)]
        public ?User $user
    ) {}

    public function get(): ?User
    {
        return $this->user;
    }
}
