<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Command\Commands\ModalMakeCommand;

class ModalScaffolder extends MultipleScaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return ModalMakeCommand::class;
    }

    /**
     * Get the suggestions.
     *
     * @return array<string, string>
     */
    public function suggestions(): array
    {
        return [
            'index' => 'Index',
            'show' => 'Show',
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
        ];
    }
}
