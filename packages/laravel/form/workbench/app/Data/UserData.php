<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    #[Max(255)]
    public string $name;

    #[Max(255)]
    public string $email;
}
