<?php

declare(strict_types=1);

namespace Honed\Command\Tests\Stubs;

use Honed\Command\Concerns\HasCache;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasCache;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
    ];
}
