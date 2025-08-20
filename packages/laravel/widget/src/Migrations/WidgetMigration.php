<?php

namespace Honed\Widget\Migrations;

use Honed\Widget\Concerns\InteractsWithDatabase;
use Illuminate\Database\Migrations\Migration;

abstract class WidgetMigration extends Migration
{
    use InteractsWithDatabase;

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
}
