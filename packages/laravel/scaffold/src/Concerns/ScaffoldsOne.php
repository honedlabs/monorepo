<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\multiselect;

/**
 * @phpstan-require-implements \Honed\Scaffold\Contracts\FromCommand
 * @phpstan-require-implements \Honed\Core\Contracts\HasLabel
 */
trait ScaffoldsOne
{
    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        if (confirm($this->getLabel())) {
            $this->addCommand($this->withMakeCommand());
        }
    }
}