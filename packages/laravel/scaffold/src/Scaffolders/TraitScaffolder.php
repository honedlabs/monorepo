<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Scaffold\Contracts\Suggestible;
use Illuminate\Support\Collection;

use function Laravel\Prompts\multiselect;

/**
 * @implements \Honed\Scaffold\Contracts\Suggestible<int>
 */
class TraitScaffolder extends Scaffolder implements Suggestible
{
    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return true;
    }

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
        $selected = multiselect(
            label: 'What traits do you want to add to the model to use?',
            options: $suggestions,
        );

        $this->getContext()->addImports($selected);

        $this->getContext()
            ->addTraits(
                array_map(
                    fn (string $trait) => $this->newTrait()->name($trait),
                    $selected
                )
            );
    }

    /**
     * Get the suggestions.
     *
     * @return list<string>
     */
    public function suggestions(): array
    {
        /** @var list<string> */
        return (new Collection(config()->array('scaffold.traits', [])))
            ->reject(fn (string $trait) => ! trait_exists($trait))
            ->toArray();
    }
}
