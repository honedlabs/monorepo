<?php

declare(strict_types=1);

namespace App\Data;

use Honed\Data\Attributes\ArrayParameter;
use Honed\Data\Data\FormData;
use Spatie\LaravelData\Attributes\Validation\Present;

class ProductUsersData extends FormData
{
    /**
     * @var array<int, int>
     */
    #[Present, ArrayParameter('id')]
    public ?array $user_ids;
}
