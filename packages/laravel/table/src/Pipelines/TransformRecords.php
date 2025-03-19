<?php

declare(strict_types=1);

namespace Honed\Table\Pipelines;

use Closure;
use Honed\Action\InlineAction;
use Honed\Table\Columns\Column;
use Honed\Table\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
class TransformRecords
{
    /**
     * Transform the records.
     * 
     * @param  \Honed\Table\Table<TModel, TBuilder>  $table
     * @return \Honed\Table\Table<TModel, TBuilder>
     */
    public function __invoke(Table $table, Closure $next): Table
    {
        $actions = $table->getInlineActions();
        $columns = $table->getCachedColumns();
        $records = $table->getRecords();
        $serialize = $table->isWithAttributes();

        $table->setRecords(
            \array_map(
                static fn (Model $record) => 
                    static::createRecord($record, $columns, $actions, $serialize),
                $records
            )
        );

        return $next($table);
    }

    /**
     * Create a record for the table.
     * 
     * @param  TModel  $record
     * @param  array<int,\Honed\Table\Columns\Column<TModel, TBuilder>>  $columns
     * @param  array<int,\Honed\Action\InlineAction>  $actions
     * @param  bool  $serialize
     * @return array<string,mixed>
     */
    public static function createRecord(
        $model, 
        $columns, 
        $actions, 
        $serialize = false
    ) {
        [$named, $typed] = Table::getModelParameters($model);

        $actions = \array_map(
            static fn (InlineAction $action) => $action->resolveToArray($named, $typed),
            $actions
        );

        $record = $serialize ? $model->toArray() : [];

        $row = Arr::mapWithKeys(
            $columns,
            static function (Column $column) use ($model, $named, $typed) {
                $value = $column->hasValue()
                    ? $column->evaluate($column->getValue(), $named, $typed)
                    : Arr::get($model, $column->getName());

                return [
                    $column->getParameter() => [
                        'value' => $column->apply($value),
                        'extra' => $column->resolveExtra($named, $typed),
                    ],
                ];
            },
        );

        return \array_merge($record, $row, ['actions' => $actions]);
    }
}
