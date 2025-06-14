<?php

declare(strict_types=1);

namespace Honed\Action\Tests\Stubs;

use Honed\Action\Concerns\HasActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasActions;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
    ];

    protected $actions = ProductActions::class;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->public_id = Str::uuid();
        });
    }

    /**
     * Get the public ID of the product.
     */
    public function getPublicId(): string
    {
        return $this->public_id->toString();
    }

    /**
     * Make the product free.
     */
    public function makeFree(): void
    {
        $this->price = 0;
        $this->save();
    }
}
