<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\User;
use Honed\Data\Attributes\ArrayParameter;
use Honed\Data\Attributes\Validation\ForeignId;
use Honed\Data\Data\FormData;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class ProductData extends FormData
{
    #[ArrayParameter('id')]
    public ?int $user_id;
}
