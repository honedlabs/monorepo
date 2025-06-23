<?php

declare(strict_types=1);

namespace Honed\Table\Pipes;

use Honed\Core\Pipe;
use Honed\Table\EmptyState;

/**
 * @template TClass of \Honed\Table\Table
 *
 * @extends Pipe<TClass>
 */
class CreateEmptyState extends Pipe
{
    /**
     * Run the after refining logic.
     *
     * @param  TClass  $instance
     * @return void
     */
    public function run($instance)
    {
        if (filled($instance->getRecords())) {
            $instance->emptyState(null);
            
            return;
        }

        if (! $instance->getEmptyState()) {
            $instance->emptyState(EmptyState::make());
        }

        $emptyState = $instance->getEmptyState();

        $emptyState->evaluate(match (true) {
            $instance->isFiltering() => $instance->getFilteringCallback(),
            $instance->isSearching() => $instance->getSearchingCallback(),
            $instance->isRefining() => $instance->getRefiningCallback(),
            default => null
        });
    }
}
