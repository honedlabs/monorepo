<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\ProductBuilder;
use Honed\Disable\Concerns\Disableable;
use Honed\Disable\Contracts\Disableable as DisableableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model implements DisableableContract
{
    use Disableable;

    /**
     * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\ProductFactory>
     */
    use HasFactory;

    /**
     * The attributes that cannot be mass assigned.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Begin querying the model.
     *
     * @return ProductBuilder<$this>
     */
    public static function query()
    {
        /** @var ProductBuilder<$this> */
        return parent::query();
    }

    /**
     * Get the user that owns the product.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @return ProductBuilder<$this>
     */
    public function newEloquentBuilder($query)
    {
        return new ProductBuilder($query);
    }
}
