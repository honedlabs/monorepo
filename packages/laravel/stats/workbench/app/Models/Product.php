<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Laravel\Scout\Searchable;
use Workbench\App\Enums\Status;
use Honed\Table\Concerns\HasTable;
use Honed\Stats\Concerns\HasOverview;
use Workbench\App\Tables\ProductTable;
use Illuminate\Database\Eloquent\Model;
use Workbench\App\Overviews\ProductOverview;
use Illuminate\Database\Eloquent\SoftDeletes;
use Workbench\Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /**
     * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Workbench\Database\Factories\ProductFactory>
     */
    use HasFactory;

    /**
     * @use \Honed\Stats\Concerns\HasOverview<\Workbench\App\Overviews\ProductOverview>
     */
    use HasOverview;

    /**
     * The factory for the model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Factories\Factory>
     */
    protected static $factory = ProductFactory::class;

    /**
     * The overview for the model.
     *
     * @var class-string<\Honed\Stats\Overview>
     */
    protected static $overviewClass = ProductOverview::class;

    /**
     * The attributes that cannot be mass assigned.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, class-string>
     */
    protected $casts = [
        'status' => Status::class,
    ];

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
     * Get the users that have the product.
     *
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the orders for the product.
     *
     * @return HasMany<Order, $this>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
