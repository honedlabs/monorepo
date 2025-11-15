<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Support\Collection;
use Spatie\LaravelData\WithData;

use function Laravel\Prompts\multiselect;

class TraitScaffolder extends Scaffolder
{
    /**
     * The concerns to be suggested.
     *
     * @var list<string>
     */
    protected $traits = [
        WithData::class,
    ];

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
        $traits = $this->getTraits();

        if (empty($traits)) {
            return;
        }

        $selected = multiselect(
            label: 'What traits do you want to add to the model to use?',
            options: $traits,
        );

        $this->getContext()->addImports($selected);
        $this->getContext()->addTraits($selected);
    }

    /**
     * Get the contracts for the context.
     *
     * @return list<string>
     */
    protected function getTraits(): array
    {
        return (new Collection($this->traits))
            ->reject(fn (string $trait) => ! trait_exists($trait))
            ->toArray();
    }
}
