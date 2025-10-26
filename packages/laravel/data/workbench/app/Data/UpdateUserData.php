<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\Product;
use Honed\Data\Attributes\Validation\ForeignId;
use Honed\Data\Concerns\PartitionsData;
use Honed\Data\Contracts\Partitionable;

class UpdateUserData extends UserData implements Partitionable
{
    use PartitionsData;

    /**
     * @var array<int, int>
     */
    #[ForeignId(Product::class, 'id')]
    public array $products;

    /**
     * Define the partitions for the data.
     *
     * @return array<string, list<string>>
     */
    public function partitions(): array
    {
        return [
            'user' => ['name'],
            'products' => ['products'],
        ];
    }
}
