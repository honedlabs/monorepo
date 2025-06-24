<?php

declare(strict_types=1);

namespace Honed\Table\Exports;

use Closure;
use Generator;
use Honed\Table\Contracts\ExportsTable;
use Honed\Table\Exports\Concerns\HasExportEvents;
use Honed\Table\Table;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TableExport implements FromGenerator, ExportsTable, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;
    use HasExportEvents;

    /**
     * The query to export.
     *
     * @var \Honed\Table\Table
     */
    protected $table;

    /**
     * Create a new table export.
     *
     * @param  \Honed\Table\Table  $table
     * @param  array<class-string<\Maatwebsite\Excel\Events\Event>, callable>  $events
     * @return void
     */
    public function __construct(Table $table, array $events = [])
    {
        $this->table($table);
        $this->events($events);
    }

    /**
     * Set the table to export.
     *
     * @param  \Honed\Table\Table  $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get the source of the export.
     *
     * @return \Generator<array<string, mixed>>
     */
    public function generator(): Generator
    {
        $columns = $this->table->getHeadings();

        foreach ($this->table->getRecords() as $record) {
            yield array_map(
                static fn ($column) => $column->value($record)[0],
                $columns
            );
        }
    }

    /**
     * Get the headings for the export.
     *
     * @return array<int, string>
     */
    public function headings(): array
    {
        return array_map(
            static fn ($heading) => $heading->getLabel(),
            $this->table->getHeadings()

        );
    }
    
    /**
     * Get the styles for the export.
     *
     * @param  \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet  $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        $columns = $this->table->getHeadings();
        $index = 'A';

        foreach ($columns as $column) {
            $style = $column->getExportStyle();

            match (true) {
                is_array($style) => $sheet->getStyle($index)->applyFromArray($style),
                $style instanceof Closure => $style($sheet->getStyle($index)),
                default => null,
            };

            $index++;
        }
    }

    /**
     * Register the events for the export.
     *
     * @return array<class-string<\Maatwebsite\Excel\Events\Event>, callable>
     */
    public function registerEvents(): array
    {
        return $this->events;
    }
}
