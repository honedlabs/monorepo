<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Laravel\Scout\Searchable;
use Workbench\App\Enums\Status;
use Honed\Table\Concerns\HasTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Workbench\Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Workbench\App\Tables\ProductTable;

class Product extends Model
{
    use HasTable;
    use Searchable;

    /**
     * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Workbench\Database\Factories\ProductFactory>
     */
    use HasFactory;
    
    use SoftDeletes;

    /**
     * The factory for the model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Factories\Factory>
     */
    protected static $factory = ProductFactory::class;

    /**
     * The table for the model.
     *
     * @var class-string<\Honed\Table\Table>
     */
    protected static $tableClass = ProductTable::class;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    /**
     * Dummy method to test the getter.
     *
     * @return string
     */
    public function price()
    {
        return '$10.00';
    }
}
