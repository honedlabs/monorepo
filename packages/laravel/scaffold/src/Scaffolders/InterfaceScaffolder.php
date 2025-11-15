<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Honed\Core\Contracts\HasIcon;
use Honed\Core\Contracts\HasLabel;
use Honed\Form\Contracts\CanBeSearched;
use Illuminate\Support\Collection;

use function Laravel\Prompts\multiselect;

class InterfaceScaffolder extends Scaffolder
{
    /**
     * The interfaces to be suggested.
     *
     * @var list<string>
     */
    protected $interfaces = [
        HasLabel::class,
        HasIcon::class,
        CanBeSearched::class,
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
        $interfaces = $this->getInterfaces();

        if (empty($interfaces)) {
            return;
        }

        $selected = multiselect(
            label: 'What interfaces do you want to add the model to implement?',
            options: $interfaces,
        );

        $this->getContext()->addImports($selected);
        $this->getContext()->addInterfaces($selected);
    }

    /**
     * Get the contracts for the context.
     *
     * @return list<string>
     */
    protected function getInterfaces(): array
    {
        return (new Collection($this->interfaces))
            ->reject(fn (string $interface) => ! interface_exists($interface))
            ->toArray();
    }
}
