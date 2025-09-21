<?php

declare(strict_types=1);

namespace Honed\Author\Contracts;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
interface Authorable
{
    /**
     * Set the value of the "created_by" column.
     *
     * @return $this
     */
    public function setCreatedBy(mixed $id): static;

    /**
     * Set the value of the "updated_by" column.
     *
     * @return $this
     */
    public function setUpdatedBy(mixed $id): static;

    /**
     * Get the fully qualified "created_by" column.
     */
    public function getQualifiedCreatedByColumn(): string;

    /**
     * Get the fully qualified "updated_by" column.
     */
    public function getQualifiedUpdatedByColumn(): string;
}
