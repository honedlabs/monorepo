<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Action\Action;
use Honed\Table\Actions\InlineAction;
use Honed\Table\Columns\Column;
use Honed\Table\Tests\Stubs\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait HasRecords
{
    /**
     * The records of the table retrieved from the resource.
     * 
     * @var \Illuminate\Support\Collection<int,mixed>|null
     */
    protected $records = null;

    /**
     * @var array<string,mixed>
     */
    protected $meta = [];

    /**
     * Get the records of the table.
     *
     * @return array<int,array<string,mixed>>|null
     */
    public function getRecords(): ?array
    {
        return $this->records;
    }

    /**
     * Determine if the table has records.
     */
    public function hasRecords(): bool
    {
        return ! \is_null($this->records);
    }

    /**
     * Format the records using the provided columns.
     * 
     * @param \Illuminate\Support\Collection<int,\Honed\Table\Columns\Column> $activeColumns
     */
    public function formatAndPaginateRecords(Collection $activeColumns): void
    {
        if (! $this->hasRecords()) {
            return;
        }

        $this->records = $this->getRecords()
            ->reduce(fn (array $records, Model $record) => 
                \array_push($records, $this->formatRecord($record, $activeColumns)), 
            []);
    }

    /**
     * Format a record using the provided columns.
     * 
     * @param \Illuminate\Database\Eloquent\Model $record
     * @param \Illuminate\Support\Collection<int,\Honed\Table\Columns\Column> $activeColumns
     * 
     * @return array<string,mixed>
     */
    protected function formatRecord(Model $record, Collection $columns): array
    {
        $reducing = false;

        $actions = $this->inlineActions()
            ->filter(fn (Action $action) => $action->isAllowed($record))
            ->map(fn (Action $action) => $action->resolve()->toArray())
            ->all();

        $key = $record->{$this->getKeyname()};

        $formatted = match ($reducing) {
            true => [],
            false => $record->toArray(),
        };

        foreach ($columns as $column) {
            $formatted[$column->getName()] = $column->format($record);
        }

        $formatted['actions'] = $actions;
        $formatted['key'] = $key;

        return $formatted;
    }
}
