<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Support\Str;

use function Laravel\Prompts\multiselect;
use Honed\Scaffold\Contracts\Suggestible;
use Honed\Command\Commands\ResponseMakeCommand;
use Honed\Scaffold\Support\PendingCommand;

/**
 * @implements \Honed\Scaffold\Contracts\Suggestible<string>
 */
class ResponseScaffolder extends Scaffolder implements Suggestible
{
    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists(ResponseMakeCommand::class);
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
        $responses = multiselect(
            label: 'Select which responses to scaffold for the model.',
            options: ['all' => 'All', ...$suggestions],
        );

        if (in_array('all', $responses)) {
            $responses = $suggestions;
        }

        foreach ($responses as $response) {
            $this->addCommand($this->withMakeCommand($response));
        }
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
    protected function withMakeCommand(string $response): PendingCommand
    {
        return $this->newCommand()
            ->command(ResponseMakeCommand::class)
            ->arguments([
                'name' => $this->suffixName($this->prefixName(Str::ucfirst($response), 'Response')),
                // "--{$response}" => true,
                // '--body' => $this->getBody(),
            ]);
    }
}