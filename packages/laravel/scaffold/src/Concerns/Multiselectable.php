<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Honed\Scaffold\Support\PendingCommand;

use function Laravel\Prompts\multiselect;

/**
 * @phpstan-require-implements \Honed\Scaffold\Contracts\Suggestible<string>
 * @phpstan-require-implements \Honed\Scaffold\Contracts\Scaffolder
 */
trait Multiselectable
{   
    /**
     * Use the given command to scaffold the input.
     */
    abstract protected function withMakeCommand(string $action): PendingCommand;

    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        $suggestions = $this->suggestions();

        if (empty($suggestions)) {
            return;
        }

        /** @var list<string> */
        $actions = multiselect(
            label: 'Select which actions to scaffold for the model.',
            options: ['all' => 'All', ...$suggestions],
        );

        if (in_array('all', $actions)) {
            $actions = $suggestions;
        }

        foreach ($actions as $action) {
            $this->addCommand($this->withMakeCommand($action));
        }
    }
}