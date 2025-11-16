<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Stats\Commands\OverviewMakeCommand;

class StatsScaffolder extends SingleScaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return OverviewMakeCommand::class;
    }
}
