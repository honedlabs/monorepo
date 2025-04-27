<?php

declare(strict_types=1);

namespace Honed\Command\Tests\Stubs;

use Honed\Command\Attributes\Cache;
use Honed\Command\Attributes\Repository;
use Honed\Command\Concerns\HasCache;
use Illuminate\Database\Eloquent\Model;

#[Repository(ProductRepository::class)]
#[Cache(ProductCache::class)]
class Product extends Model
{
    use HasCache;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
    ];
}
