<?php

declare(strict_types=1);

namespace Honed\Widget\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    /**
     * The attributes that are not mass assignable.
     * 
     * @var array<int, string>
     */
    public $guarded = [];

    /**
     * Get the attributes that should be cast.
     * 
     * @return array<int, string>
     */
    public function casts()
    {
        return [
            'data' => 'array',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
        
    }

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
    {
        return $this->table ?? config('widget.table');
    }

    // public function getWidget();

    // public function putData(): void

    // public function getData()
}