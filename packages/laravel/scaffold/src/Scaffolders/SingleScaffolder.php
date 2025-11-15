<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Scaffold\Support\PendingCommand;
use Honed\Scaffold\Support\Utility\Writer;

use function Laravel\Prompts\confirm;

abstract class SingleScaffolder extends CommandScaffolder
{
    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        if (confirm($this->label())) {
            $this->addCommand($this->withMakeCommand());
        }
    }

    /**
     * Get the label for the confirm prompt.
     */
    public function label(): string
    {
        $type = $this->getBaseName()->snake(' ')->toString();

        return "Do you want to scaffold a {$type} class for the model?";
    }

    /**
     * Use the given command to scaffold the class.
     */
    public function withMakeCommand(): PendingCommand
    {
        return $this->newCommand()
            ->command($this->commandName())
            ->arguments($this->getArguments());
    }

    /**
     * Get the arguments for the command.
     *
     * @return array<string, mixed>
     */
    protected function getArguments(): array
    {
        return [
            'name' => $this->suffixName($this->getBaseName()->toString()),
            '--model' => $this->getName(),
            // '--body' => $this->getBody()->toString()
        ];
    }

    /**
     * Get the body of the class.
     */
    protected function getBody(): Writer
    {
        return Writer::make();
    }
}
