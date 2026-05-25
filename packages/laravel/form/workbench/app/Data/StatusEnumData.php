<?php

declare(strict_types=1);

namespace App\Data;

use App\Enums\Status;
use Spatie\LaravelData\Data;

class StatusEnumData extends Data
{
    public Status $status;
}
