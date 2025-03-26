<?php

declare(strict_types=1);

namespace Honed\Lock\Tests\Stubs;

use Honed\Lock\Concerns\HasLocks;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasLocks;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
    ];
}
