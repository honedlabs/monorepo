<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Support\Str;

class MigrationScaffolder extends SingleScaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return MigrateMakeCommand::class;
    }

    /**
     * Get the arguments for the command.
     *
     * @return array<string, mixed>
     */
    protected function getArguments(): array
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->getName())));

        return [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ];
    }
}
