<?php

declare(strict_types=1);

namespace Honed\Table\Pipes;

use Honed\Core\Pipe;
use Honed\Table\Columns\Column;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * @template TClass of \Honed\Table\Table
 *
 * @extends Pipe<TClass>
 */
class SelectColumns extends Pipe
{
    /**
     * Run the prepare columns logic.
     */
    public function run(): void
    {
        $columns = $this->instance->getHeadings();

        $builder = $this->instance->getBuilder();

        foreach ($columns as $column) {
            $this->select($column, $builder);
        }
    }

    /**
     * Select the column.
     * 
     * @param \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $builder
     */
    protected function select(Column $column, Builder $builder): void
    {
        if ($column->isNotSelectable()) {
            return;
        }

        $selects = $column->getSelects();

        if (empty($selects)) {
            /** @var string $name */
            $name = $column->getName();

            $selects[] = $name;
        }

        $this->instance->select(
            array_map(
                static fn ($select) => $column->qualifyColumn($select, $builder),
                $selects
            )
        );
    }
}
