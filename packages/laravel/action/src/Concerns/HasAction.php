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
     * @return bool
     */
    public function hasAction()
    {
        return ! \is_null($this->action);
    }
}