<?php

declare(strict_types=1);

namespace App\Models;

use App\Forms\ProductForm;
use Honed\Form\Concerns\HasForm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /**
     * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\ProductFactory>
     */
    use HasFactory;

    /**
     * @use \Honed\Form\Concerns\HasForm<\App\Forms\ProductForm>
     */
    use HasForm;

    /**
     * The attributes that cannot be mass assigned.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The form class for the product model.
     * 
     * @var string|null
     */
    public static $formClass = null;

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