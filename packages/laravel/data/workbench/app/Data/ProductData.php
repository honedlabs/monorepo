<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\User;
use Honed\Data\Attributes\ArrayParameter;
use Honed\Data\Attributes\Transformers\TransformToData;
use Honed\Data\Data\FormData;

class ProductData extends FormData
{
    #[TransformToData(UserData::class, User::class, columns: ['name'])]
    #[ArrayParameter('id')]
    public ?int $user_id;
}
