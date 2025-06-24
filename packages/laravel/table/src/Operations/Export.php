<?php

declare(strict_types=1);

namespace Honed\Table\Operations;

use Closure;
use Honed\Action\Contracts\Action;
use Honed\Action\Operations\Concerns\CanBeChunked;
use Honed\Action\Operations\Operation;
use Honed\Table\Contracts\ExportsTable;
use Honed\Table\Exports\Concerns\HasExportEvents;
use Honed\Table\Table;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

use function array_merge;

class Export extends Operation implements Action
{
    use Concerns\CanLimitRecords;
    use Concerns\Exportable;
    use HasExportEvents;
    // use HasExport;

    /**
     * The callback to be used to create the export from the table.
     *
     * @var Closure(\Honed\Table\Table, ExportsTable, \Illuminate\Http\Request):mixed
     */
    protected $using;

    /**
     * The exporter to be used for the export.
     *
     * @var class-string<ExportsTable>|null
     */
    protected $exporter;

    /**
     * The registered callback to be called if the export is not downloaded.
     *
     * @var callable
     */
    protected $after;

    /**
     * Register the callback to be used to create the export from the table.
     *
     * @param  (Closure(\Honed\Table\Table, ExportsTable, \Illuminate\Http\Request):mixed)|null  $callback
     * @return $this
     */
    public function using($callback)
    {
        $this->using = $callback;

        return $this;
    }

    /**
     * Get the callback to be used to create the export from the table.
     *
     * @return Closure(\Honed\Table\Table, ExportsTable, \Illuminate\Http\Request):mixed
     */
    public function getUsingCallback()
    {
        return $this->using;
    }

    /**
     * Set the exporter class to be used to generate the export.
     *
     * @param  class-string<ExportsTable>|null  $exporter
     * @return $this
     */
    public function exporter($exporter)
    {
        $this->exporter = $exporter;

        return $this;
    }

    /**
     * Get the exporter class to be used to generate the export.
     *
     * @return class-string<ExportsTable>
     */
    public function getExporter()
    {
        return $this->exporter ?? ExportsTable::class;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            ...parent::toArray(),
            'actionable' => true,
        ];
    }

    public function handle(Table $table)
    {
        /** @var ExportsTable */
        $export = App::make($this->getExporter(), [
            'table' => $table,
            'events' => $this->getEvents(),
        ]);

        $filename = $this->getFilename();

        $type = $this->getFileType();

        if ($use = $this->getUsingCallback()) {
            return $this->evaluate($use);
        }

        $response = match (true) {
            $this->isDownload() => Excel::download($export, $filename, $type),
            $this->isQueued() => Excel::queue($export, $filename, $type)->onQueue($this->getQueue()),
            default => Excel::store($export, $filename, $this->getDisk()),
        };

        return $response;
    }
}
