<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Spatie\LaravelData\Commands\DataMakeCommand;

class DataScaffolder extends MultipleScaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return DataMakeCommand::class;
    }

    /**
     * Get the suggestions for the user.
     *
     * @return array<string, string>
     */
    public function suggestions(): array
    {
        return [
            'store' => 'Store',
            'update' => 'Update',
            'show' => 'Show',
            'search' => 'Search',
        ];
    }
}
