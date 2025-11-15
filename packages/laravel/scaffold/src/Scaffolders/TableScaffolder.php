<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Scaffold\Contracts\Property;
use Honed\Scaffold\Support\Utility\Writer;
use Honed\Table\Commands\TableMakeCommand;

class TableScaffolder extends SingleScaffolder
{
    /**
     * The command to be run.
     */
    public function commandName(): string
    {
        return TableMakeCommand::class;
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
