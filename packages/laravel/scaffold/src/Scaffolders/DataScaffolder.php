<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Core\Contracts\HasLabel;

use Honed\Scaffold\Contracts\FromCommand;
use Honed\Scaffold\Contracts\Suggestible;
use Honed\Scaffold\Concerns\ScaffoldsMany;
use Honed\Scaffold\Support\PendingCommand;
use Honed\Scaffold\Support\Utility\Writer;
use Spatie\LaravelData\Commands\DataMakeCommand;

/**
 * @implements Suggestible<string>
 */
class DataScaffolder extends Scaffolder implements Suggestible, FromCommand, HasLabel
{
    use ScaffoldsMany;

    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists(DataMakeCommand::class);
    }

    /**
     * Get the label.
     */
    public function getLabel(): string
    {
        return 'Select which data classes to scaffold for the model.';
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

    /**
     * Use the `honed:form` command to scaffold the form.
     */
    public function withMakeCommand(string $input = ''): PendingCommand
    {
        return $this->newCommand()
            ->command(DataMakeCommand::class)
            ->arguments([
                'name' => $this->suffixName('Data', $this->prefixName($input)),
                // '--body' => $this->getBody()
            ]);
    }

    /**
     * Get the body of the table.
     */
    protected function getBody(): Writer
    {
        return Writer::make();
    }
}
