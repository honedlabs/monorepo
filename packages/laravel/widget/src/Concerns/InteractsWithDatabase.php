<?php

declare(strict_types=1);

namespace Honed\Widget\Concerns;

use Illuminate\Support\Facades\DB;

/**
 * @internal
 */
trait InteractsWithDatabase
{
    /**
     * Get the migration table name for widgets.
     */
    public function getTableName(): string
    {
        /** @var string|null */
        $table = config('widget.drivers.database.table');

        /** @var string */
        return ($table === null || $table === 'null') ? 'widgets' : $table;
    }
}