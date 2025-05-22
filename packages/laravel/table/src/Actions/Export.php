<?php

declare(strict_types=1);

namespace Honed\Table\Actions;

class Export
{
    /**
     * The callback to be used to create the export from the table.
     * 
     * @var \Closure
     */
    protected $using;

    /**
     * .
     */
    protected $queue;

    /**
     * The default queue to be used for the export.
     * 
     * @var string
     */
    protected static $useQueue = 'default';
    
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