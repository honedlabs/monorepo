<?php

declare(strict_types=1);

namespace Honed\Table;

use Honed\Core\Concerns\HasIcon;
use Honed\Core\Primitive;
use Illuminate\Support\Arr;

class EmptyState extends Primitive //implements NullAsUndefined
{
    use HasIcon;

    /**
     * The heading of the empty state.
     *
     * @var string
     */
    protected $heading = 'No results found';

    /**
     * The description of the empty state.
     *
     * @var string
     */
    protected $description = 'There are no results to display.';

    /**
     * The label of the empty state action.
     *
     * @var array<int, \Honed\Action\Action>
     */
    protected $actions = [];

    /**
     * The callback to modify the state when refiners are being applied.
     *
     * @var \Closure|null
     */
    protected $refining;

    /**
     * The callback to modify the state when filters are being applied.
     *
     * @var \Closure|null
     */
    protected $filtering;

    /**
     * The callback to modify the state when searching is being applied.
     *
     * @var \Closure|null
     */
    protected $searching;

    /**
     * Create a new empty state.
     *
     * @param  string|null  $heading
     * @param  string|null  $description
     * @return static
     */
    public static function make($heading = null, $description = null)
    {
        return resolve(static::class)
            ->when($heading, fn ($emptyState, $heading) => 
                $emptyState->heading($heading)
            )
            ->when($description, fn ($emptyState, $description) => 
                $emptyState->description($description)
            );
    }

    /**
     * Set the heading of the empty state.
     *
     * @param  string|null  $heading
     * @return $this
     */
    public function heading($heading)
    {
        $this->heading = $heading;

        return $this;
    }

    /**
     * Get the heading of the empty state.
     *
     * @return string
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * Set the description of the empty state.
     *
     * @param  string|null  $description
     * @return $this
     */
    public function description($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the description of the empty state.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the actions of the empty state. This will replace any existing actions.
     *
     * @param  \Honed\Action\PageAction|iterable<int, \Honed\Action\PageAction>  $actions
     * @return $this
     */
    public function actions(...$actions)
    {
        /** @var array<int, \Honed\Action\PageAction> */
        $actions = Arr::flatten($actions);

        $this->actions = $actions;

        return $this;
    }

    /**
     * Get the actions of the empty state.
     *
     * @return array<int, \Honed\Action\PageAction>
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Register a callback to modify the state when refiners are being applied.
     *
     * @param  \Closure  $refining
     * @return $this
     */
    public function refining($refining)
    {
        $this->refining = $refining;

        return $this;
    }

    /**
     * Get the callback to modify the state when refiners are being applied.
     *
     * @return \Closure|null
     */
    public function getRefiningState()
    {
        return $this->refining;
    }

    /**
     * Register a callback to modify the state when filters are being applied.
     *
     * @param  \Closure  $filtering
     * @return $this
     */
    public function filtering($filtering)
    {
        $this->filtering = $filtering;

        return $this;
    }

    /**
     * Get the callback to modify the state when filters are being applied.
     *
     * @return \Closure|null
     */
    public function getFilteringState()
    {
        return $this->filtering;
    }

    /**
     * Register a callback to modify the state when searching is being applied.
     *
     * @param  \Closure  $searching
     * @return $this
     */
    public function searching($searching)
    {
        $this->searching = $searching;

        return $this;
    }

    /**
     * Get the callback to modify the state when searching is being applied.
     *
     * @return \Closure|null
     */
    public function getSearchingState()
    {
        return $this->searching;
    }

    /**
     * Get the actions of the empty state as an array.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function actionsToArray()
    {
        return array_map(
            static fn ($action) => $action->toArray(),
            $this->getActions()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($named = [], $typed = [])
    {
        return [
            'heading' => $this->getHeading(),
            'description' => $this->getDescription(),
            'icon' => $this->getIcon(),
            'actions' => $this->actionsToArray(),
        ];
    }
}
