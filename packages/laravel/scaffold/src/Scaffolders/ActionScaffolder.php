<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Action\ActionServiceProvider;
use Honed\Scaffold\Contracts\Suggestible;

use function Laravel\Prompts\multiselect;

class ActionScaffolder extends Scaffolder implements Suggestible
{
    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists(ActionServiceProvider::class);
    }

    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        $actions = multiselect(
            label: 'Select which actions to scaffold for the model.',
            options: $this->suggestions()
        );
    }

    /**
     * Get the suggestions for the user.
     *
     * @return array<string, string>
     */
    public function suggestions(): array
    {
        return [
            'Create',
            'Update',
            'Delete',
        ];
    }
}
