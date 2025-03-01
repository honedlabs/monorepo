<?php

declare(strict_types=1);

namespace Honed\Crumb\Concerns;

trait IsTerminable
{
    /**
     * @var bool
     */
    protected $terminating = false;

    /**
     * @var bool
     */
    protected $terminated = false;

    /**
     * Set the trail to terminate when a crumb in the trail matches.
     *
     * @param bool $terminating
     * @return $this
     */
    public function terminating($terminating = true)
    {
        $this->terminating = $terminating;

        return $this;
    }

    /**
     * Determine if the trail is terminating.
     *
     * @return bool
     */
    public function isTerminating()
    {
        return $this->terminating;
    }

    /**
     * Determine if the trail has terminated.
     * 
     * @return bool
     */
    public function hasTerminated()
    {
        return $this->terminated;
    }

    /**
     * Set the trail to have terminated.
     *
     * @param bool $terminated
     * @return $this
     */
    protected function terminate($terminate = true)
    {
        $this->terminated = $terminate;

        return $this;
    }
}
