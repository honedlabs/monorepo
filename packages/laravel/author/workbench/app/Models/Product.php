<?php

declare(strict_types=1);

namespace App\Models;

use Honed\Author\Concerns\Authorable;
use Honed\Author\Concerns\Deleteable;
use Honed\Author\Contracts\Authorable as AuthorableContract;
use Honed\Author\Contracts\Deleteable as DeleteableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model implements AuthorableContract, DeleteableContract
{
    use Authorable;
    use Deleteable;

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
     * Get the user that owns the product.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
