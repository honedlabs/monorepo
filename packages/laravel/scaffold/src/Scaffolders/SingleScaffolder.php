<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Support\Str;

use Honed\Core\Contracts\HasLabel;
use Honed\Scaffold\Contracts\FromCommand;
use Honed\Scaffold\Contracts\Suggestible;
use Honed\Scaffold\Concerns\ScaffoldsMany;
use Honed\Scaffold\Support\PendingCommand;
use Honed\Scaffold\Support\Utility\Writer;
use Spatie\LaravelData\Commands\DataMakeCommand;
use Illuminate\Support\Stringable;

use function Laravel\Prompts\confirm;

abstract class SingleScaffolder extends Scaffolder
{
    /**
     * The command to be run.
     * 
     * @return class-string<\Illuminate\Console\Command>
     */
    abstract public function commandName(): string;

    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists($this->commandName());
    }

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
     */
    protected function getArguments(): array
    {
        return [
            'name' => $this->suffixName($this->getBaseName()->toString()),
            // '--body' => $this->getBody()->toString()
        ];
    }

    /**
     * Get the class base name.
     */
    protected function getBaseName(): Stringable
    {
        return (new Stringable($this->commandName()))
            ->classBasename()
            ->replace('Command', '')
            ->replace('Make', '')
            ->studly();
    }

    /**
     * Get the body of the class.
     */
    protected function getBody(): Writer
    {
        return Writer::make();
    }
}
