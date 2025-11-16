<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Infolist\Commands\InfolistMakeCommand;

class InfolistScaffolder extends SingleScaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return InfolistMakeCommand::class;
    }
}
