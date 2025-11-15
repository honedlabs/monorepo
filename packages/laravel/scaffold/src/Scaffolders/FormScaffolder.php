<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Form\Commands\FormMakeCommand;

class FormScaffolder extends MultipleScaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return FormMakeCommand::class;
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
        ];
    }
}
