<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

trait HasAction
{
    /**
     * @var \Closure|null
     */
    protected $action = null;

    /**
     * Execute the action handler using the provided data.
     */
    abstract public function execute($data): void;

    /**
     * Set the action handler.
     * 
     * @return $this
     */
    public function action(\Closure $action = null): static
    {
        if (! \is_null($action)) {
            $this->action = $action;
        }

        return $this;
    }

    /**
     * Get the action handler.
     */
    public function getAction(): ?\Closure
    {
        return $this->action;
    }

    /**
     * @return bool
     */
    public function hasAction()
    {
        return ! \is_null($this->action);
    }
}