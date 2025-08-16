<?php

namespace Honed\Widget\Migrations;

use Illuminate\Database\Migrations\Migration;

abstract class WidgetMigration extends Migration
{
    /**
     * Get the migration connection name.
     */
    public function getConnection(): string
    {
        /** @var string|null */
        $connection = config('widget.drivers.database.connection');

        /** @var string */
        return ($connection === null || $connection === 'null') 
            ? config('database.default')
            : $connection;
    }

    /**
     * Get the migration table name.
     */
    public function getTable(): string
    {
        /** @var string */
        $table = config('widget.drivers.database.table', 'widgets');

        /** @var string */
        return ($table === null || $table === 'null') ? 'widgets' : $table;
    }
}
