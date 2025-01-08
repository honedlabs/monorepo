<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

trait HasAction
{
    /**
     * @var \Closure|null
     */
    protected $action = null;

    abstract public function handle();

    /**
     * @param \Closure|null $action
     * @return \Closure|null|$this
     */
    public function action($action = null)
    {
        return \is_null($action) 
            ? $this->action 
            : $this;
    }

    /**
     * @return bool
     */
    public function hasAction()
    {
        return ! \is_null($this->action);
    }
}