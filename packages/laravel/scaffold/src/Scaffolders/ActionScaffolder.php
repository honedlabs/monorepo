<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Support\Str;
use Honed\Action\ActionServiceProvider;

use function Laravel\Prompts\multiselect;
use Honed\Scaffold\Contracts\Suggestible;
use Honed\Action\Commands\ActionMakeCommand;

/**
 * @implements Suggestible<string>
 */
class ActionScaffolder extends Scaffolder implements Suggestible
{
    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists(ActionMakeCommand::class);
    }

    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        $suggestions = $this->suggestions();

        if (empty($suggestions)) {
            return;
        }

        /** @var list<string> */
        $actions = multiselect(
            label: 'Select which actions to scaffold for the model.',
            options: $suggestions,
        );

        foreach ($actions as $action) {
            $this->addCommand(
                $this->newCommand()
                    ->command(ActionMakeCommand::class)
                    ->arguments([
                        'name' => $this->suffixName(Str::ucfirst($action)),
                        'action' => $action,
                        'model' => $this->getName()
                    ])
            );
        }
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
}
