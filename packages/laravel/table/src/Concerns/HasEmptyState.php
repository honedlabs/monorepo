<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Closure;
use Honed\Table\EmptyState;

trait HasEmptyState
{
    /**
     * The empty state of the table.
     *
     * @var EmptyState|null
     */
    protected $emptyState;

    /**
     * Set the empty state of the table.
     *
     * @param  EmptyState|Closure  $emptyState
     * @return $this
     */
    public function emptyState($emptyState)
    {
        match (true) {
            $emptyState instanceof Closure => $this->evaluate($emptyState),
            default => $this->emptyState = $emptyState,
        };

        return $this;
    }

    /**
     * Get the empty state of the table.
     *
     * @return EmptyState|null
     */
    public function getEmptyState()
    {
        return $this->emptyState;
    }

    /**
     * Set the heading of the empty state.
     *
     * @param  string  $heading
     * @return $this
     */
    public function emptyStateHeading($heading)
    {
        $this->newEmptyState()->heading($heading);

        return $this;
    }

    /**
     * Set the description of the empty state.
     *
     * @param  string  $description
     * @return $this
     */
    public function emptyStateDescription($description)
    {
        $this->newEmptyState()->description($description);

        return $this;
    }

    /**
     * Set the icon of the empty state.
     *
     * @param  string  $icon
     * @return $this
     */
    public function emptyStateIcon($icon)
    {
        $this->newEmptyState()->icon($icon);

        return $this;
    }

    /**
     * Set the actions of the empty state.
     *
     * @param  \Honed\Action\Action|iterable<int, \Honed\Action\Action>  ...$actions
     * @return $this
     */
    public function emptyStateActions(...$actions)
    {
        $this->newEmptyState()->actions(...$actions);

        return $this;
    }

    /**
     * Register a callback to update the empty state when filtering is applied.
     *
     * @param  Closure  $callback
     * @return $this
     */
    public function whenEmptyStateFiltering($callback)
    {
        $this->newEmptyState()->filtering($callback);

        return $this;
    }

    /**
     * Register a callback to update the empty state when searching is applied.
     *
     * @param  Closure  $callback
     * @return $this
     */
    public function whenEmptyStateSearching($callback)
    {
        $this->newEmptyState()->searching($callback);

        return $this;
    }

    /**
     * Register a callback to update the empty state when refinements are being applied
     *
     * @param  Closure  $callback
     * @return $this
     */
    public function whenEmptyStateRefining($callback)
    {
        $this->newEmptyState()->refining($callback);

        return $this;
    }

    /**
     * Get the empty state as an array.
     *
     * @return array<string, mixed>|null
     */
    public function emptyStateToArray()
    {
        return $this->emptyState?->toArray();
    }

    /**
     * Create a new empty state instance.
     *
     * @return EmptyState
     */
    protected function newEmptyState()
    {
        return $this->emptyState ??= EmptyState::make();
    }
}
