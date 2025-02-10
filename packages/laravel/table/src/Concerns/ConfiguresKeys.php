<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

trait ConfiguresKeys
{
    const PageKey = 'page';

    const ColumnKey = 'columns';

    /**
     * The key for pagination.
     * 
     * @var string|null
     */

    protected $pageKey;

    /**
     * The default key for pagination.
     * 
     * @var string
     */
    protected static $defaultPageKey = self::PageKey;


    /**
     * The key for the columns to show.
     * 
     * @var string|null
     */
    protected $columnsKey;

    /**
     * The default key for the columns to show.
     * 
     * @var string
     */
    protected static $defaultColumnsKey = self::ColumnKey;

    /**
     * Get the key for pagination.
     */
    public function getPageKey(): string

    {
        return match (true) {
            \property_exists($this, 'pageKey') && ! \is_null($this->pageKey) => $this->pageKey,
            \method_exists($this, 'pageKey') => $this->pageKey(),
            default => static::getDefaultPageKey(),
        };
    }

    /**
     * Get the key for the columns to show.
     */
    public function getColumnKey(): string
    {
        return match (true) {

            \property_exists($this, 'columnsKey') && ! \is_null($this->columnsKey) => $this->columnsKey,
            \method_exists($this, 'columnsKey') => $this->columnsKey(),
            default => static::getDefaultColumnsKey(),
        };
    }

    /**
     * Get the default page key for all tables.
     */
    public static function getDefaultPageKey(): string
    {
        return static::$defaultPageKey;
    }

    /**
     * Get the default columns key for all tables.
     */
    public static function getDefaultColumnsKey(): string
    {
        return static::$defaultColumnsKey;
    }

    /**
     * Set the default page key for all tables.
     */
    public static function usePageKey(string $key): void
    {
        static::$defaultPageKey = $key;
    }

    /**
     * Set the default columns key for all tables.
     */
    public static function useColumnsKey(string $key): void
    {
        static::$defaultColumnsKey = $key;
    }

    /**
     * Get the keys for the table as an array.
     * 
     * @return array<string,string>
     */
    public function keysToArray(): array
    {
        return [

            'records' => $this->getKeyName(),
            'sorts' => $this->getSortKey(),
            'filters' => $this->getFilterKey(),
            'search' => $this->getSearchKey(),
            'toggle' => $this->getToggleKey(),
            'pages' => $this->getPagesKey(),
            ...($this->hasMatches() ? ['match' => $this->getMatchKey()] : []),
        ];
    }
}

