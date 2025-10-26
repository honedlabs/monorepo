<?php

declare(strict_types=1);

namespace App\Data;

use App\Classes\GlobalCounter;
use App\Models\Product;
use Honed\Data\Attributes\Validation\ForeignId;
use Honed\Data\Concerns\PartitionsData;
use Honed\Data\Contracts\Partitionable;
use Honed\Data\Contracts\Translatable;

class UpdateUserData extends UserData implements Partitionable, Translatable
{
    use PartitionsData;

    /**
     * @var array<int, int>
     */
    #[ForeignId(Product::class, 'id')]
    public array $products = [];

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

    /**
     * Increment the global counter.
     */
    public static function translate(...$payloads): void
    {
        GlobalCounter::increment();
    }
}
