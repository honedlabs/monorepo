<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Database\Console\Factories\FactoryMakeCommand;

class FactoryScaffolder extends SingleScaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return FactoryMakeCommand::class;
    }
}
