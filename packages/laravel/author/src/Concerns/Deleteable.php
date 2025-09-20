<?php

declare(strict_types=1);

namespace Honed\Author\Concerns;

use Honed\Author\Author;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Foundation\Auth\User
 * 
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait Deleteable
{
    use EloquentSoftDeletes;

    /**
     * Boot the deleteable trait for a model.
     */
    public static function bootDeleteable(): void
    {
        static::deleting(function (self $model) {
            $id = Author::identifier();

            $model->setDeletedBy($id);
        });
    }

    /**
     * Get the deleting model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<TModel, $this>
     */
    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(Author::model(), $this->getDeletedByColumn());
    }

    /**
     * Set the value of the "deleted_by" column.
     *
     * @return $this
     */
    public function setDeletedBy(mixed $id): static
    {
        $column = $this->getDeletedByColumn();

        if (! is_null($column) && ! $this->isDirty($column)) {
            $this->{$column} = $id;
        }

        return $this;
    }

    /**
     * Get the name of the "deleted_by" column.
     */
    public function getDeletedByColumn(): ?string
    {
        return defined(static::class.'::DELETED_BY') ? static::DELETED_BY : 'deleted_by';
    }

    /**
     * Get the fully qualified "deleted_by" column.
     */
    public function getQualifiedDeletedByColumn(): string
    {
        return $this->qualifyColumn($this->getDeletedByColumn());
    }
}