<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Support\Str;
use Honed\Action\ActionServiceProvider;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;
use Honed\Scaffold\Contracts\Suggestible;
use Honed\Table\Commands\TableMakeCommand;
use Honed\Action\Commands\ActionMakeCommand;
use Honed\Scaffold\Contracts\FromCommand;
use Honed\Scaffold\Contracts\Property;
use Honed\Scaffold\Support\PendingCommand;
use Honed\Scaffold\Support\Utility\Writer;
use Illuminate\Support\Collection;

/**
 * @implements Suggestible<string>
 */
class TableScaffolder extends Scaffolder implements FromCommand
{
    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists(TableMakeCommand::class);
    }

    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        if (confirm('Do you want to scaffold a table for the model?')) {
            $this->addCommand($this->withMakeCommand());
        }
    }

    /**
     * Use the `honed:table` command to scaffold the table.
     */
    public function withMakeCommand(string $input = ''): PendingCommand
    {
        return $this->newCommand()
            ->command(TableMakeCommand::class)
            ->arguments([
                'name' => $this->getName(),
                '--body' => $this->getBody()
            ]);
    }

    /**
     * Get the body of the table.
     */
    protected function getBody(): Writer
    {
        return Writer::make()
            // ->indent(8)
            ->line('return $this')
            ->line('->columns([')
            ->lineFor($this->getContext()
                ->getProperties(),
                // ->reject(fn (Property $property) =>
                //     $property instanceof SupportsTables
                // ),
                fn (Writer $writer, Property $property) => $writer
                    // ->line($property->getTableColumn().',')
                    ->line()
            )
            ->line('])')
            ->finish();
    }
}
