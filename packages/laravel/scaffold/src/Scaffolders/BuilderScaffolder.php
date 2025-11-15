<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use SplFileInfo;
use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

use function Laravel\Prompts\select;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\confirm;

use function Laravel\Prompts\suggest;
use Honed\Action\ActionServiceProvider;
use function Laravel\Prompts\multiselect;
use Honed\Command\CommandServiceProvider;
use Honed\Scaffold\Scaffolders\Scaffolder;
use Honed\Scaffold\Support\PendingCommand;
use Honed\Scaffold\Properties\DateProperty;
use Honed\Command\Commands\BuilderMakeCommand;

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
    public function suggest(): void
    {
        if (confirm('Would you like to scaffold a builder for the model?')) {

            $name = $this->suffixName('Builder');

            $qualifiedName = $this->qualifyGenerator($name, BuilderMakeCommand::class);

            $this->addImport($qualifiedName);

            $this->addCommand(
                $this->newCommand()
                    ->command(BuilderMakeCommand::class)
                    ->arguments([
                        'name' => $name,
                    ])
            );

            $this->addMethod(
                $this->newMethod()
                    ->override()
                    ->annotate('Create a new query builder for the model.')
                    ->annotate()
                    ->annotateReturn("\\{$qualifiedName}}")
                    ->signature('newEloquentBuilder($query)')
                    // ->line('return new Builder($query);')
                    // ->return('new Builder($query);')
            );

            $this->addMethod(
                $this->newMethod()
                    ->override()
                    ->annotate('Begin querying the model.')
                    ->annotate()
                    ->annotate("@return \\{$qualifiedName}")
                    ->static()
                    ->signature('query()')
                    // ->line("@var \\{$qualifiedName}")
                    // ->line('return parent::query();')
            );
        }
    }
}