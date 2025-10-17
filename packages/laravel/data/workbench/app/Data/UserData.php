<?php

declare(strict_types=1);

namespace App\Data;

use Honed\Data\Data\FormData;
use Spatie\LaravelData\Data;

class UserData extends FormData
{
    public string $name;
}
