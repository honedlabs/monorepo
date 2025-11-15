<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Command\Commands\ResponseMakeCommand;
use Honed\Core\Contracts\HasLabel;
use Honed\Scaffold\Concerns\ScaffoldsMany;
use Honed\Scaffold\Contracts\FromCommand;
use Honed\Scaffold\Contracts\Suggestible;
use Honed\Scaffold\Support\PendingCommand;
use Illuminate\Support\Str;

/**
 * @implements \Honed\Scaffold\Contracts\Suggestible<string>
 */
class ResponseScaffolder extends Scaffolder implements FromCommand, HasLabel, Suggestible
{
    use ScaffoldsMany;

    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists(ResponseMakeCommand::class);
    }

    /**
     * Get the label.
     */
    public function getLabel(): string
    {
        return 'Select which responses to scaffold for the model.';
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

    /**
     * Use the `honed:response` command to scaffold the response.
     */
    public function withMakeCommand(string $input = ''): PendingCommand
    {
        return $this->newCommand()
            ->command(ResponseMakeCommand::class)
            ->arguments([
                'name' => $this->suffixName('Response', $this->prefixName(Str::ucfirst($input))),
                // "--{$response}" => true,
                // '--body' => $this->getBody(),
            ]);
    }
}
