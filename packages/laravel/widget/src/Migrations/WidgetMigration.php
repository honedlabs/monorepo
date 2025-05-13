<?php

declare(strict_types=1);

namespace Honed\Widget\Migrations;

use Illuminate\Database\Migrations\Migration;

abstract class WidgetMigration extends Migration
{
    /**
     * Get the migration connection name.
     *
     * @return string
     */
    public function getConnection()
    {
        $connection = config('widget.drivers.database.connection');

        return ($connection === null || $connection === 'null') ? config('database.default') : $connection;
    }

    /**
     * Get the migration table name.
     *
     * @return string
     */
    public function getTable()
    {
        return config('widget.drivers.database.table', 'widgets');
    }
}
