<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

trait HasPagination
{
    const PerPage = 10;

    /**
     * The pagination options for the table.
     * 
     * An array will provide the user the ability to select how many rows are
     * shown per page.
     * 
     * @var int|array<int,int>|null
     */
    protected $pagination;

    /**
     * The default pagination amount for the table if pagination is an array.
     * 
     * @var int|null
     */
    protected $defaultPagination;

    /**
     * @var int|array<int,int>
     */
    protected static $perPage = self::PerPage;

    /**
     * @var int
     */
    protected static $defaultPerPage = self::PerPage;

    /**
     * Retrieve the pagination options for the table.
     * 
     * @return int|array<int,int>
     */
    public function getPagination(): int|array
    {
        if (isset($this->pagination)) {
            return $this->pagination;
        }

        return static::$perPage;
    }

    /**
     * Retrieve the default pagination options for the table.
     * 
     * @return int
     */
    public function getDefaultPagination(): int
    {
        if (isset($this->defaultPagination)) {
            return $this->defaultPagination;
        }

        return static::$defaultPerPage;
    }

    /**
     * Set the per page amount for all tables.
     * 
     * @param int|array<int,int> $perPage
     */
    public static function perPage(int|array $perPage): void
    {
        static::$perPage = $perPage;
    }

    /**
     * Set the default per page amount for all tables.
     * 
     * @param int $perPage
     */
    public static function defaultPerPage(int $perPage): void
    {
        static::$defaultPerPage = $perPage;
    }
}