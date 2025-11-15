<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Foundation\Console\PolicyMakeCommand;
use Illuminate\Routing\Console\ControllerMakeCommand;

class ControllerScaffolder extends SingleScaffolder
{
    /**
     * The command to be run.
     * 
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return ControllerMakeCommand::class;
    }
}
