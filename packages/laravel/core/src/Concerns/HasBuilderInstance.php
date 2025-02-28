<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasBuilderInstance
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>|null
     */
    protected $builder;

    /**
     * Set the builder instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @return $this
     */
    public function builder($builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * Determine if the builder instance has been set.
     *
     * @return bool
     */
    public function hasBuilder()
    {
        return ! \is_null($this->builder);
    }

    /**
     * Get the builder instance.
     *
     * @return \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>
     */
    public function getBuilder()
    {
        if (! $this->hasBuilder()) {
            throw new \RuntimeException('Builder instance has not been set.');
        }

        return $this->builder;
    }

    /**
     * Create a new builder instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model>|\Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $query
     * @return \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>
     */
    public static function createBuilder($query)
    {
        if ($query instanceof Model) {
            return $query::query();
        }

        if (\is_string($query) && \class_exists($query)) {
            return $query::query();
        }

        if (! $query instanceof Builder) {
            throw new \InvalidArgumentException('Expected a model class name or a query instance.');
        }

        return $query;
    }
}
