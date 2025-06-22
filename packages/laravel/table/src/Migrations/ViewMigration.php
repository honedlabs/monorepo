<?php

declare(strict_types=1);

namespace Honed\Table\Migrations;

use Illuminate\Database\Migrations\Migration;

abstract class ViewMigration extends Migration
{
    /**
     * Get the migration connection name.
     *
     * @return string
     */
    public function getConnection()
    {
        $connection = config('table.views.connection');

        /** @var string */
        return ($connection === null || $connection === 'null') ? config('database.default') : $connection;
    }

    /**
     * Get the migration table name.
     *
     * @return string
     */
    public function getTableName()
    {
        $table = config('table.views.table');

        /** @var string */
        return ($table === null || $table === 'null') ? 'views' : $table;
    }
}