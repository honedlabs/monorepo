<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Support\Str;
use Honed\Action\ActionServiceProvider;

use function Laravel\Prompts\multiselect;
use Honed\Scaffold\Contracts\Suggestible;
use Honed\Action\Commands\ActionMakeCommand;
use Honed\Scaffold\Concerns\Multiselectable;
use Honed\Scaffold\Support\PendingCommand;

/**
 * @implements Suggestible<string>
 */
class ActionScaffolder extends Scaffolder implements Suggestible
{
    use Multiselectable;

    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists(ActionMakeCommand::class);
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
    protected function withMakeCommand(string $action): PendingCommand
    {
        return $this->newCommand()
            ->command(ActionMakeCommand::class)
            ->arguments([
                'name' => $this->suffixName(Str::ucfirst($action)),
                '--action' => $action,
                '--model' => $this->getName()
                // '--body' => $this->getBody(),
            ]);
    }
}
