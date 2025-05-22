<?php

namespace Honed\Table\Actions;

use Honed\Action\Action;
use Honed\Action\ActionGroup;
use Honed\Action\InlineAction;
use Honed\Table\Contracts\TableExporter;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Facades\Excel;

class Export extends Action
{
    /**
     * The callback to be used to create the export from the table.
     * 
     * @var \Closure
     */
    protected $using;

    /**
     * The events that this export should listen to.
     * 
     * @var array<class-string<\Maatwebsite\Excel\Events\Event>, callable>
     */
    protected $events = [];

    /**
     * Whether to download the export or not.
     * 
     * @var bool
     */
    protected $download = true;

    /**
     * The queue to be used for the export.
     * 
     * @var string|null
     */
    protected $queue;

    /**
     * The default queue to be used for the export.
     * 
     * @var string
     */
    protected static $useQueue = 'default';

    /**
     * The disk for the export to be stored on.
     * 
     * @var string|null
     */
    protected $disk;

    /**
     * The default disk for the export to be stored on, null will use the 
     * default disk supplied by the filesystem config.
     * 
     * @var string|null
     */
    protected static $useDisk = null;

    /**
     * Whether to only use records that have been filtered.
     * 
     * @var bool|null
     */
    protected $filtered;

    /**
     * Whether to only use records that have been filtered by default.
     * 
     * @var bool|null
     */
    protected static $useFiltered = true;

    /**
     * Whether to only use records that have been selected.
     * 
     * @var bool|null
     */
    protected $selected;

    /**
     * Whether to only use records that have been selected by default.
     * 
     * @var bool|null
     */
    protected static $useSelected = true;

    public function bulk()
    {

    }

    public function page()
    {

    }

    /**
     * Set the queue to be used for the export.
     * 
     * @param  string|null  $queue
     * @return $this
     */
    public function queue($queue)
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * Set the queue to be used for the export.
     * 
     * @param  string|null  $queue
     * @return void
     */
    public static function useQueue($queue)
    {
        static::$useQueue = $queue;
    }

    /**
     * Set the disk to be used for the export.
     * 
     * @param  string|null  $disk
     * @return void
     */
    public static function useDisk($disk)
    {
        static::$useDisk = $disk;
    }

    /**
     * Set whether to only use records that have been filtered.
     * 
     * @param  bool|null  $filtered
     * @return void
     */
    public static function onlyFiltered($filtered = true)
    {
        static::$useFiltered = $filtered;
    }

    /**
     * Set whether to only use records that have been selected.
     * 
     * @param  bool|null  $selected
     * @return void
     */
    public static function onlySelected($selected = true)
    {
        static::$useSelected = $selected;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveToArray($parameters = [], $typed = [])
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'type' => $this->getType(),
            'icon' => $this->getIcon(),
            'extra' => $this->getExtra(),
            'actionable' => true,
            'confirm' => $this->getConfirm()?->resolveToArray($parameters, $typed),
        ];
    }

    /**
     * 
     */
    public function execute($record)
    {
        /** @var \Honed\Table\Contracts\TableExporter */
        $export = App::make(TableExporter::class);

        $filename = $this->getFileName();

        $type = $this->getType();

        return match (true) {
            $this->downloads() => Excel::download($export, $filename, $type),
            $this->queues() => Excel::queue($export, $filename, $type),
            default => Excel::store($export, $filename, $this->getDisk()),
        };
    }
    

    /**
     * Statics:
     * onlyFilteredRecords
     * onlySelectedRecords
     * onlyShownColumns
     * useQueue
     * useDisk
     * 
     * Methods
     * events
     * queue
     * download
     * exporter
     * using
     * 
     * Column methods
     * export
     * exportFormat
     * dontExport
     * exportStyle
     * 
     * We feed in the table to this class.
     */

}