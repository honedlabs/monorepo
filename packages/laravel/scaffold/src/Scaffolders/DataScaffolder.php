<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Core\Contracts\HasLabel;
use Honed\Scaffold\Concerns\ScaffoldsMany;
use Honed\Scaffold\Contracts\FromCommand;
use Honed\Scaffold\Contracts\Suggestible;
use Honed\Scaffold\Support\PendingCommand;
use Honed\Scaffold\Support\Utility\Writer;
use Spatie\LaravelData\Commands\DataMakeCommand;

/**
 * @implements Suggestible<string>
 */
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
