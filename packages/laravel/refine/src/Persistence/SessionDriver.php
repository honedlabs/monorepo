<?php

namespace Honed\Refine\Persistence;

use Illuminate\Contracts\Session\Session;

class SessionDriver extends Driver
{
    public function __construct(
        protected Session $session,
    ) { }

    /**
     * Retrieve the data from the driver and store it in memory.
     * 
     * @return void
     */
    public function resolve()
    {
        $this->resolvedData = $this->session->get($this->key);
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