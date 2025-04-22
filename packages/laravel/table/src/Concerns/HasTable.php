<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\Attributes\UseTable;
use Honed\Table\Table;

/**
 * @template TTable of \Honed\Table\Table
 */
trait HasTable
{
    /**
     * The table instance.
     *
     * @var class-string<\Honed\Table\Table>|null
     */
    protected static $table;

    /**
     * Get a new factory instance for the model.
     *
     * @param  \Closure|null  $before
     * @return TTable
     */
    public static function table($before = null)
    {
        return static::newTable($before) 
            ?? Table::tableForModel(static::class, $before);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return TTable|null
     */
    protected static function newTable($before = null)
    {
        if (isset(static::$table)) {
            return static::$table::make($before);
        }

        if ($table = static::getUseTableAttribute()) {
            return $table::make($before);
        }

        return null;
    }

    /**
     * Get the table from the UseTable class attribute.
     *
     * @return class-string<\Honed\Table\Table>|null
     */
    protected static function getUseTableAttribute()
    {
        $attributes = (new \ReflectionClass(static::class))
            ->getAttributes(UseTable::class);

        if ($attributes !== []) {
            $useTable = $attributes[0]->newInstance();

            return $useTable->tableClass;
        }
    }
}
