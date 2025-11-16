<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

use Honed\Scaffold\Contracts\IsNullable;
use Illuminate\Support\Stringable;

use function Laravel\Prompts\select;

class ForeignProperty extends Property implements IsNullable
{
    /**
     * The type of the schema column.
     *
     * @var string
     */
    protected $column = 'foreignId';

    /**
     * The suggested names for the property.
     *
     * @var list<string>
     */
    protected $suggestedNames = [
        'user_id',
        'parent_id',
    ];

    /**
     * The strategy for when the foreign record is deleted.
     *
     * @var string
     */
    protected $strategy;

    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        parent::prompt();

        $this->promptForOnDelete();
    }

    /**
     * Get the blueprint for the property, without the trailing semicolon.
     */
    public function getBlueprint(): Stringable
    {
        $constrained = (new Stringable($this->name))
            ->replace('_id', '')
            ->plural()
            ->toString();

        return parent::getBlueprint()
            ->append('->constrained(\'', $constrained, '\')')
            ->when($$this->getStrategy(),
                fn (Stringable $string, string $strategy) => $string
                    ->append('->', $strategy, '()'),
            );
    }

    /**
     * Get the strategy for the property.
     */
    public function getStrategy(): ?string
    {
        return match ($this->strategy) {
            'cascade' => 'cascadeOnDelete',
            'restrict' => 'restrictOnDelete',
            'null' => 'nullOnDelete',
            default => null,
        };
    }

    /**
     * Prompt the user for the on delete strategy.
     */
    public function promptForOnDelete(): void
    {
        if (! $this->confirms('delete strategy')) {
            return;
        }

        /** @var string */
        $strategy = select('Select a strategy for when the foreign record is deleted', [
            'none' => 'None',
            'cascade' => 'Cascade',
            'restrict' => 'Restrict',
            'null' => 'Null',
        ]);

        if ($strategy !== 'none') {
            $this->strategy = $strategy;
        }
    }
}
