<?php

declare(strict_types=1);

namespace Honed\Table\Pagination;

use Honed\Core\Primitive;

class PaginationData//extends SimplePrimitive
{
    /**
     * Whether the pagination data is empty.
     *
     * @var bool
     */
    protected $empty;

    final public function __construct() {}

    /**
     * Create a new pagination data instance.
     * 
     * @param \Illuminate\Support\Collection<int, *> $paginator
     */
    public static function make(mixed $paginator): static
    {
        return resolve(static::class)->empty($paginator->isEmpty());
    }

    /**
     * Set the empty state of the pagination data.
     *
     * @return $this
     */
    public function empty(bool $empty): static
    {
        $this->empty = $empty;

        return $this;
    }

    /**
     * Determine if the pagination data is empty.
     */
    public function isEmpty(): bool
    {
        return $this->empty;
    }
}