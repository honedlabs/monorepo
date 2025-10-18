<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\User;
use Honed\Data\Attributes\ArrayParameter;
use Honed\Data\Attributes\Validation\ForeignId;
use Honed\Data\Data\FormData;
use Spatie\LaravelData\Attributes\Validation\Present;
use Spatie\LaravelData\Data;

class ProductUsersData extends FormData
{
    /**
     * @var array<int, int>
     */
    #[Present, ArrayParameter('id')]
    public ?array $user_ids;
}
