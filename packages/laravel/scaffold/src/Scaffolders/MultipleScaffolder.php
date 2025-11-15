<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Scaffold\Contracts\Suggestible;
use Honed\Scaffold\Support\PendingCommand;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;

/**
 * @implements Suggestible<string>
 */
abstract class MultipleScaffolder extends CommandScaffolder implements Suggestible
{
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
        $inputs = multiselect(
            label: $this->label(),
            options: ['all' => 'All', ...$suggestions],
            scroll: 8
        );

        foreach ($inputs as $input) {
            $this->addCommand($this->withMakeCommand($input));
        }
    }

    /**
     * Get the label for the confirm prompt.
     */
    public function label(): string
    {
        $types = $this->getBaseName()->plural()->snake(' ')->toString();

        return "Select which {$types} to scaffold for the model.";
    }

    /**
     * Use the given command to scaffold the class.
     */
    public function withMakeCommand(string $input): PendingCommand
    {
        return $this->newCommand()
            ->command($this->commandName())
            ->arguments($this->getArguments($input));
    }

    /**
     * Get the name for the class, prefixed with the input and suffixed with the base name.
     */
    protected function getResolvedName(string $input): string
    {
        return $this->prefixName(Str::ucfirst($input), $this->suffixName($this->getBaseName()->toString()));
    }

    /**
     * Get the arguments for the command.
     *
     * @return array<string, mixed>
     */
    protected function getArguments(string $input): array
    {
        return [
            'name' => $this->getResolvedName($input),
            // '--body' => $this->getBody(),
        ];
    }
}
