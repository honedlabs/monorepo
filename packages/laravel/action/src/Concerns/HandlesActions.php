<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

use Honed\Action\BulkAction;
use Honed\Action\InlineAction;

trait HandlesActions
{
    /**
     * @var array<int,\Honed\Action\Action>
     */
    public $actions;

    /**
     * @return \Illuminate\Support\Collection<int,\Honed\Action\Action>
     */
    public function getActions()
    {
        return collect(match(true) {
            \property_exists($this, 'actions') && !\is_null($this->actions) => $this->actions,
            \method_exists($this, 'actions') => $this->actions(),
            default => [],
        });
    }

    /**
     * @return bool
     */
    public function hasActions()
    {
        return $this->getActions()->isNotEmpty();
    }

    /**
     * @return \Illuminate\Support\Collection<int,\Honed\Action\InlineAction>
     */
    public function inlineActions()
    {
        return $this->getActions()
            ->filter(static fn ($action) => $action instanceof InlineAction)
            ->values();
    }

    /**
     * @return \Illuminate\Support\Collection<int,\Honed\Action\BulkAction>
     */
    public function bulkActions()
    {
        return $this->getActions()
            ->filter(static fn ($action) => $action instanceof BulkAction)
            ->values();
    }
}