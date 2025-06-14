<?php

declare(strict_types=1);

namespace Honed\Refine\Persistence;

use Illuminate\Contracts\Session\Session;

class SessionDriver extends Driver
{
    public function __construct(
        protected Session $session,
    ) {}

    /**
     * Retrieve the data from the driver and store it in memory.
     *
     * @return $this
     */
    public function resolve()
    {
        $this->resolved = $this->session->get($this->key, []);

        return $this;
    }

    /**
     * Set the session to use for the driver.
     *
     * @param  Session  $session
     * @return $this
     */
    public function session($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Persist the data to the session.
     *
     * @return void
     */
    public function persist()
    {
        match (true) {
            empty($this->data) => $this->session->forget($this->key),
            default => $this->session->put($this->key, $this->data),
        };
    }
}
