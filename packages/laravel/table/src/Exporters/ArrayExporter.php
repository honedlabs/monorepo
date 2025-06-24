<?php

declare(strict_types=1);

namespace Honed\Table\Exporters;

use Closure;
use Generator;
use Honed\Table\Contracts\ExportsTable;
use Honed\Table\Exports\Concerns\HasExportEvents;
use Honed\Table\Table;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArrayExporter extends Exporter implements FromArray
{
    /**
     * Get the source of the export.
     *
     * @return array<int, array<string, mixed>>
     */
    public function array(): array
    {
        return [];
    }
}
