<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Chart\Commands\ChartMakeCommand;
use Honed\Chart\Enums\ChartType;
use Illuminate\Support\Arr;

class ChartScaffolder extends MultipleScaffolder
{
    /**
     * The command to be run.
     *
     * @return class-string<\Illuminate\Console\Command>
     */
    public function commandName(): string
    {
        return ChartMakeCommand::class;
    }

    /**
     * Get the suggestions for the user.
     *
     * @return array<string, string>
     */
    public function suggestions(): array
    {
        return Arr::mapWithKeys(
            ChartType::cases(),
            fn (ChartType $type) => [$type->value => $type->name]
        );
    }
}
