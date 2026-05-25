<?php

declare(strict_types=1);

namespace App\Data;

use App\Enums\Status;
use Spatie\LaravelData\Data;

class TagsStatusListData extends Data
{
    /** @var list<Status> */
    public array $tags;
}
