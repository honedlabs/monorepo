<?php

declare(strict_types=1);

namespace App\Models;

use Honed\Core\Contracts\HasLabel;
use Honed\Form\Concerns\CanBeSearched;
use Honed\Form\Concerns\HasForm;
use Honed\Form\Contracts\CanBeSearched as CanBeSearchedContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model implements HasLabel, CanBeSearchedContract
{
    /**
     * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\ProductFactory>
     */
    use HasFactory;

    /**
     * @use \Honed\Form\Concerns\HasForm<\App\Forms\ProductForm>
     */
    use HasForm;

    use CanBeSearched;

    /**
     * The form class for the product model.
     *
     * @var string|null
     */
    public static $formClass = null;

    /**
     * The attributes that cannot be mass assigned.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Get the user that owns the product.
     *
     * @return BelongsTo<User, static>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the users that have the product.
     *
     * @return BelongsToMany<User, static>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, ProductUser::class);
    }

    /**
     * Get the label for the product.
     */
    public function getLabel(): string
    {
        return $this->name;
    }
}
