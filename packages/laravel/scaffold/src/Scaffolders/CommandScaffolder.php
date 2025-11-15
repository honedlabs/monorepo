<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Support\Stringable;

abstract class CommandScaffolder extends Scaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    abstract public function commandName(): string;

    /**
     * Get the label for the prompt.
     */
    abstract public function label(): string;

    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists($this->commandName());
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
}
