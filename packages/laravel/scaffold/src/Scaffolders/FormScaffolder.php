<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use function Laravel\Prompts\confirm;

use Honed\Core\Contracts\HasLabel;
use Honed\Form\Commands\FormMakeCommand;
use Honed\Scaffold\Concerns\ScaffoldsMany;
use Honed\Scaffold\Contracts\FromCommand;
use Honed\Scaffold\Contracts\Suggestible;
use Honed\Scaffold\Support\PendingCommand;
use Honed\Scaffold\Support\Utility\Writer;
use Honed\Table\Commands\TableMakeCommand;

/**
 * @implements Suggestible<string>
 */
class FormScaffolder extends Scaffolder implements Suggestible, FromCommand, HasLabel
{
    use ScaffoldsMany;

    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists(FormMakeCommand::class);
    }

    /**
     * Get the label.
     */
    public function getLabel(): string
    {
        return 'Select which forms to scaffold for the model.';
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

    /**
     * Use the `honed:form` command to scaffold the form.
     */
    public function withMakeCommand(string $input = ''): PendingCommand
    {
        return $this->newCommand()
            ->command(FormMakeCommand::class)
            ->arguments([
                'name' => $this->suffixName('Form', $this->prefixName($input)),
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
