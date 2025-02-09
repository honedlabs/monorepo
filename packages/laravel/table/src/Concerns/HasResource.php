<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait HasResource
{
    /**
     * @var class-string<\Illuminate\Database\Eloquent\Model>|\Illuminate\Database\Eloquent\Model|null
     */
    protected $resource;

    /**
     * @return \Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model>|\Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>
     */
    public function getResource(): Model|string|Builder
    {
        return match (true) {
            \method_exists($this, 'resource') => $this->resource(),
            \property_exists($this, 'resource') && !\is_null($this->resource) => $this->resource,
            default => $this->guessResource()
        };
    }

    /**
     * @return class-string<\Illuminate\Database\Eloquent\Model>
     */
    public function guessResource(): string 
    {
        return str(static::class)
            ->classBasename()
            ->beforeLast('Table')
            ->singular()
            ->prepend('\\App\\Models\\')
            ->value();
    }
}
