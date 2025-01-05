<?php

namespace Honed\Table\Tests\Stubs;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    // use Searchable;

    protected $casts = [
        'status' => Status::class,
    ];
}
