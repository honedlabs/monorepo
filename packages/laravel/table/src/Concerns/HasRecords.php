<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\Actions\InlineAction;
use Honed\Table\Tests\Stubs\Product;
use Illuminate\Database\Eloquent\Model;
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
     * Get the records of the table.
     *
     * @return \Illuminate\Support\Collection<int,array<string,mixed>>|null
     */
    public function getRecords(): ?Collection
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
    public function formatRecords(Collection $activeColumns): void
    {
        if (! $this->hasRecords()) {
            return;
        }

        $this->records = $this->getRecords();
    }


    // /**
    //  * @return array<int,\Honed\Action\InlineAction>
    //  */
    // protected function setActionsForRecord(Model $record): array
    // {
    //     $actions = $this->inlineActions();

    //     return $actions
    //         ->filter(fn (InlineAction $action) => $action->isAuthorized($record))
    //         ->each(fn (InlineAction $action) => $action->link->resolveLink([
    //             'record' => $record,
    //         ], [
                
    //         ]))
    //         ->values();
    // }
}
