<?php

declare(strict_types=1);

namespace Honed\Widget\Models;

use Honed\Widget\Casts\PositionCast;
use Honed\Widget\Casts\ScopeCast;
use Honed\Widget\Casts\WidgetCast;
use Honed\Widget\Concerns\InteractsWithDatabase;
use Honed\Widget\WidgetCollection;
use Illuminate\Database\Eloquent\Attributes\CollectedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $widget
 * @property string $scope
 * @property string|null $position
 * @property array<string, mixed>|null $data
 * @property \Carbon\CarbonImmutable $created_at
 * @property \Carbon\CarbonImmutable $updated_at
 */
#[CollectedBy(WidgetCollection::class)]
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
     * Set the cast for the data attribute.
     */
    public function dataCast(): string
    {
        return 'array';
    }

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
    {
        return $this->table ??= $this->getTableName();
    }

    public function newCollection(array $models = [])
    {
        return parent::newCollection($models);
    }

    /**
     * Scope a query to only include widgets for a given scope.
     *
     * @param  Builder<self>  $query
     */
    public function scopeFor(Builder $query, mixed $scope): void
    {
        $query->where('scope', $scope);
    }

    /**
     * Scope a query to only include the given widget.
     *
     * @param  Builder<self>  $query
     */
    public function scopeWidget(Builder $query, string $widget): void
    {
        $query->where('widget', $widget);
    }
}
