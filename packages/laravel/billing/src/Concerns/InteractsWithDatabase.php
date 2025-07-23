<?php

declare(strict_types=1);

namespace Honed\Billing\Concerns;

trait InteractsWithDatabase
{
    /**
     * Get the migration connection name.
     */
    public function getConnection(): string
    {
        /** @var string|null $connection */
        $connection = config('billing.drivers.database.connection');

        /** @var string */
        return ($connection === null || $connection === 'null') ? config('database.default') : $connection;
    }

    /**
     * Get the migration table name.
     */
    public function getTable(): string
    {
        /** @var string|null $table */
        $table = config('billing.drivers.database.table');

        return ($table === null || $table === 'null') ? 'products' : $table;
    }
}
