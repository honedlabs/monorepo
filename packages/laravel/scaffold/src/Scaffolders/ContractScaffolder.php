<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Scaffold\Scaffolders\Scaffolder;
use Illuminate\Support\Collection;

use function Laravel\Prompts\multiselect;

class ContractScaffolder extends Scaffolder
{
    /**
     * The contracts to be added.
     * 
     * @var list<string>
     */
    protected $contracts = [
        // HasLabel::class,
        // CanBeSearched::class,
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
    public function suggest(): void
    {
        $contracts = multiselect(
            label: 'What contracts do you want to add to the model?',
            options: $this->getContracts(),
        );

        $this->getContext()->addImports($contracts);
        $this->getContext()->addInterfaces($contracts);
    }

    /**
     * Get the contracts for the context.
     * 
     * @return list<string>
     */
    protected function getContracts(): array
    {
        return (new Collection($this->contracts))
            ->reject(fn (string $contract) => ! interface_exists($contract))
            ->toArray();
    }

}