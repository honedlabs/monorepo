<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use function Laravel\Prompts\multiselect;

/**
 * @phpstan-require-implements \Honed\Scaffold\Contracts\FromCommand
 * @phpstan-require-implements \Honed\Scaffold\Contracts\Suggestible
 * @phpstan-require-implements \Honed\Core\Contracts\HasLabel
 */
trait ScaffoldsMany
{
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
        $inputs = multiselect(
            label: $this->getLabel(),
            options: ['all' => 'All', ...$suggestions],
            scroll: 8
        );

        foreach ($inputs as $input) {
            $this->addCommand($this->withMakeCommand($input));
        }
    }
}