<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Action\Commands\BatchMakeCommand;

class BatchScaffolder extends SingleScaffolder
{
    /**
     * The command to be run.
     */
    public function commandName(): string
    {
        return BatchMakeCommand::class;
    }
}
