<?php

declare(strict_types=1);

namespace Honed\Table\Pipes;

use Honed\Action\Operations\InlineOperation;
use Honed\Core\Pipe;
use Illuminate\Support\Arr;

/**
 * @template TClass of \Honed\Table\Table
 *
 * @extends Pipe<TClass>
 */
class CreateRecords extends Pipe
{
    /**
     * Run the after refining logic.
     *
     * @param  TClass  $instance
     * @return void
     */
    public function run($instance)
    {
        $columns = $instance->getHeadings();

        $operations = $instance->getInlineOperations();

        $records = array_map(fn ($record) => 
            $this->createRecord($record, $columns, $operations),
            $instance->getRecords()
        );

        $instance->setRecords($records);
    }

    /**
     * Create a record for the table.
     *
     * @param \Illuminate\Database\Eloquent\Model $record
     * @param array<int, \Honed\Table\Columns\Column> $columns
     * @param array<int, \Honed\Table\Operations\InlineOperation> $operations
     * @return array<string, mixed>
     */
    protected function createRecord($record, $columns, $operations)
    {
        return [
            ...$this->getColumns($record, $columns),
            'operations' => $this->getOperations($record, $operations),
        ];
    }

    /**
     * Get the operations for a record.
     *
     * @param \Illuminate\Database\Eloquent\Model $record
     * @param array<int, \Honed\Table\Operations\InlineOperation> $operations
     * @return array<int, array<string, mixed>>
     */
    protected function getOperations($record, $operations)
    {
        return array_map(
            static fn (InlineOperation $operation) => 
                $operation->record($record)->toArray(),
            array_values(
                array_filter(
                    $operations,
                    static fn (InlineOperation $operation) => 
                        $operation->record($record)->isAllowed()
                )
            )
        );
    }

    /**
     * Get the column values for a record.
     * 
     * @param \Illuminate\Database\Eloquent\Model $record
     * @param array<int, \Honed\Table\Columns\Column> $columns
     * @return array<string, array<string, mixed>>
     */
    protected function getColumns($record, $columns)
    {
        return Arr::mapWithKeys(
            $columns,
            fn ($column) => $this->getColumn($record, $column)
        );
    }

    /**
     * Get the column value for a record.
     *
     * @param \Illuminate\Database\Eloquent\Model $record
     * @param \Honed\Table\Columns\Column $column
     * @return array<string, mixed>
     */
    protected function getColumn($record, $column)
    {
        $column->record($record);

        return [];
    }
}
