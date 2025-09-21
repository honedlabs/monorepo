<?php

declare(strict_types=1);

namespace Honed\Author\Contracts;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
interface Deleteable
{
    /**
     * Set the value of the "deleted_by" column.
     *
     * @return $this
     */
    public function setDeletedBy(mixed $id): static;

    /**
     * Get the fully qualified "deleted_by" column.
     */
    public function getQualifiedDeletedByColumn(): string;
}
