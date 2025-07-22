<?php

namespace Honed\Stripe\Migrations;

use Illuminate\Database\Migrations\Migration;

abstract class BillingMigration extends Migration
{
    /**
     * Get the migration connection name.
     */
    public function getConnection(): string
    {
        /** @var string|null $connection */
        $connection = config('stripe.drivers.database.connection');

        return ($connection === null || $connection === 'null') ? config('database.default') : $connection;
    }

    /**
     * Get the migration table name.
     */
    public function getTable(): string
    {
        /** @var string|null $table */
        $table = config('stripe.drivers.database.table');

        return ($table === null || $table === 'null') ? 'products' : $table;
    }
}