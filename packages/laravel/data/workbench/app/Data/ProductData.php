<?php

declare(strict_types=1);

namespace App\Data;

use Honed\Data\Attributes\ArrayParameter;
use Honed\Data\Attributes\ToDataViaModel;
use Honed\Data\Data\FormData;
use Spatie\LaravelData\Attributes\WithTransformer;

class ProductData extends FormData
{
    // #[WithTransformer(ToDataViaModel::class)]
    #[ArrayParameter('id')]
    public ?int $user_id;
}
