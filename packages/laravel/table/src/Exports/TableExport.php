<?php

namespace Honed\Table\Exports;

use Honed\Table\Contracts\TableExporter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class TableExport implements TableExporter, WithStrictNullComparison, ShouldAutoSize
{
    use Exportable;

    /**
     * The query to export.
     * 
     * @var \Honed\Table\Table
     */
    protected $table;

    /**
     * Create a new table export instance.
     * 
     * @param  \Honed\Table\Table  $table
     * @return static
     */
    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * {@inheritdoc}
     */
    public function query()
    {
        return $this->query;
    }

    public function map($row): array
    {
        return [];
    }

    public function headings(): array
    {
        return [];
    }

}