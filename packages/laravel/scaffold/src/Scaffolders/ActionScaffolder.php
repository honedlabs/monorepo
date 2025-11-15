<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Action\Commands\ActionMakeCommand;
use Honed\Core\Contracts\HasLabel;
use Honed\Scaffold\Concerns\ScaffoldsMany;
use Honed\Scaffold\Contracts\FromCommand;
use Honed\Scaffold\Contracts\Suggestible;
use Honed\Scaffold\Support\PendingCommand;
use Illuminate\Support\Str;

/**
 * @implements Suggestible<string>
 */
class ActionScaffolder extends Scaffolder implements FromCommand, HasLabel, Suggestible
{
    use ScaffoldsMany;

    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists(ActionMakeCommand::class);
    }

    /**
     * Get the label.
     */
    public function getLabel(): string
    {
        return 'Select which actions to scaffold for the model.';
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
            'delete' => 'Delete',
        ];
    }

    /**
     * Use the `honed:action` command to scaffold the action.
     */
    public function withMakeCommand(string $input = ''): PendingCommand
    {
        return $this->newCommand()
            ->command(ActionMakeCommand::class)
            ->arguments([
                'name' => $this->prefixName(Str::ucfirst($input)),
                '--action' => $input,
                '--model' => $this->getName(),
                // '--body' => $this->getBody(),
            ]);
    }
}
