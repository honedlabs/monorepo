<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Command\Commands\BuilderMakeCommand;
use Honed\Scaffold\Support\PendingCommand;
use Honed\Scaffold\Support\PendingMethod;

use function Laravel\Prompts\confirm;

class BuilderScaffolder extends Scaffolder
{
    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists(BuilderMakeCommand::class);
    }

    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        if (confirm('Would you like to scaffold a builder for the model?')) {

            $name = $this->suffixName('Builder');

            $namespace = $this->qualifyGenerator($name, BuilderMakeCommand::class);

            $this->addImport($namespace);

            $this->addCommand($this->withMakeCommand($name, $namespace));

            $this->addMethod($this->withNewEloquentBuilderMethod($name, $namespace));

            $this->addMethod($this->withQueryMethod($name, $namespace));
        }
    }

    /**
     * Use the `honed:builder` command to scaffold the builder.
     */
    protected function withMakeCommand(string $name, string $namespace): PendingCommand
    {
        return $this->newCommand()
            ->command(BuilderMakeCommand::class)
            ->arguments([
                'name' => $name,
            ]);
    }

    /**
     * Use the `newEloquentBuilder` method to provide type-hinting for the query builder.
     */
    protected function withNewEloquentBuilderMethod(string $name, string $namespace): PendingMethod
    {
        return $this->newMethod()
            ->override()
            ->annotate('Create a new query builder for the model.')
            ->annotate()
            ->annotateReturn("\\{$namespace}")
            ->signature('newEloquentBuilder($query)')
            ->return("new {$name}(\$query);");
    }

    /**
     * Use the `query` method to provide type-hinting for the query builder.
     */
    protected function withQueryMethod(string $name, string $namespace): PendingMethod
    {
        return $this->newMethod()
            ->override()
            ->annotate('Begin querying the model.')
            ->annotate()
            ->annotateReturn("\\{$namespace}}")
            ->signature('query()')
            ->line("@var \\{$namespace}")
            ->return('parent::query();');
    }
}
