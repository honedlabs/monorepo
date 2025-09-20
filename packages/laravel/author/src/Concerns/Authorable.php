<?php

declare(strict_types=1);

namespace Honed\Author\Concerns;

use Honed\Author\Support\Author;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Foundation\Auth\User
 * 
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait Authorable
{
    /**
     * Boot the authorable trait for a model.
     */
    public static function bootAuthorable(): void
    {
        static::creating(function (self $model) {
            $id = Author::identifier();
            
            $model->setCreatedBy($id);
            $model->setUpdatedBy($id);
        });

        static::updating(function (self $model) {
            $id = Author::identifier();

            $model->setUpdatedBy($id);
        });
    }

    /**
     * Get the authoring model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TModel, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Author::model(), $this->getCreatedByColumn());
    }

    /**
     * Get the updating model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TModel, $this>
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Author::model(), $this->getUpdatedByColumn());
    }

    /**
     * Set the value of the "created_by" column.
     *
     * @return $this
     */
    public function setCreatedBy(mixed $id): static
    {
        $column = $this->getCreatedByColumn();

        if (! is_null($column) && ! $this->isDirty($column)) {
            $this->{$column} = $id;
        }

        return $this;
    }

    /**
     * Set the value of the "updated_by" column.
     *
     * @return $this
     */
    public function setUpdatedBy(mixed $id): static
    {
        $column = $this->getUpdatedByColumn();

        if (! is_null($column) && ! $this->isDirty($column)) {
            $this->{$column} = $id;
        }

        return $this;
    }

    /**
     * Get the name of the "created_by" column.
     */
    public function getCreatedByColumn(): ?string
    {
        return defined(static::class.'::CREATED_BY') ? static::CREATED_BY : 'created_by';
    }

    /**
     * Get the fully qualified "created_by" column.
     */
    public function getQualifiedCreatedByColumn(): string
    {
        return $this->qualifyColumn($this->getCreatedByColumn());
    }

    /**
     * Get the name of the "updated_by" column.
     */
    public function getUpdatedByColumn(): ?string
    {
        return defined(static::class.'::UPDATED_BY') ? static::UPDATED_BY : 'updated_by';
    }

    /**
     * Get the fully qualified "updated_by" column.
     */
    public function getQualifiedUpdatedByColumn(): string
    {
        return $this->qualifyColumn($this->getUpdatedByColumn());
    }
}