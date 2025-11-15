<?php

declare(strict_types=1);

namespace Honed\Scaffold\Contracts;

use Honed\Scaffold\Support\PendingCommand;

interface FromCommand
{
    /**
     * Use the given command to scaffold the input, if applicable.
     */
    public function withMakeCommand(string $input = ''): PendingCommand;

    /**
     * Create a new pending command instance.
     */
    public function newCommand(): PendingCommand;
}
