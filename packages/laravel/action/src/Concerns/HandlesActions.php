<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

trait HandlesActions
{
    /**
     * @var array<int,\Honed\Action\Action>
     */
    protected $actions;

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
}