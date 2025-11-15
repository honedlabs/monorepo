<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Infolist\Commands\InfolistMakeCommand;

class TableScaffolder extends SingleScaffolder
{
    /**
     * The command to be run.
     */
    public function commandName(): string
    {
        return InfolistMakeCommand::class;
    }
}
