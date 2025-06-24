<?php

declare(strict_types=1);

namespace Honed\Table\Contracts;

use Honed\Table\Table;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

/**
 * @implements WithMapping<array<string, mixed>|\Illuminate\Database\Eloquent\Model>
 */
interface ExportsTable extends WithEvents, WithHeadings, WithStyles, WithMapping
{
    /**
     * Create a new table export.
     *
     * @param  \Honed\Table\Table  $table
     * @param  array<class-string<\Maatwebsite\Excel\Events\Event>, callable>  $events
     * @return void
     */
    public function __construct(Table $table, array $events = []);
}
