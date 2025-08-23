<?php

declare(strict_types=1);

namespace Honed\Widget\Models;

use Honed\Widget\Casts\PositionCast;
use Honed\Widget\Casts\ScopeCast;
use Honed\Widget\Casts\WidgetCast;
use Honed\Widget\Concerns\InteractsWithDatabase;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use InteractsWithDatabase;

    /**
     * The attributes that are not mass assignable.
     * 
     * @var array<int, string>
     */
    public $guarded = [];

    /**
     * Get the attributes that should be cast.
     * 
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'widget' => WidgetCast::class,
            'scope' => ScopeCast::class,
            'position' => PositionCast::class,
            'data' => $this->dataCast(),
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];        
    }

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
    {
        return $this->table ??= $this->getTableName();
    }

    /**
     * Set the cast for the data attribute.
     */
    public function dataCast(): string
    {
        return 'array';
    }

    /**
     * Scope a query to only include widgets for a given scope.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     */
    public function scopeFor(Builder $query, mixed $scope): void
    {
        $query->where('scope', $scope);
    }

    /**
     * Scope a query to only include the given widget.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     */
    public function scopeWidget(Builder $query, string $widget): void
    {
        $query->where('widget', $widget);
    }
}