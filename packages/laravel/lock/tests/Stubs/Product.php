<?php

declare(strict_types=1);

namespace Honed\Lock\Tests\Stubs;

use Honed\Lock\Concerns\HasAbilities;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasAbilities;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
    ];

    public function abilities()
    {
        return [
            'update' => true,
            'delete' => true,
        ];
    }
}
