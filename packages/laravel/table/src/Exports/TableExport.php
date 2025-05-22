<?php

namespace Honed\Table\Exports;

use Honed\Table\Contracts\TableExporter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class TableExport implements TableExporter, WithStrictNullComparison
{
    use Exportable;

    /**
     * The query to export.
     * 
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * Create a new table export instance.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return static
     */
    public function __construct($query)
    {
        $this->query = $query;
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
        //
    }

    public function headings(): array
    {
        return [];
    }

}