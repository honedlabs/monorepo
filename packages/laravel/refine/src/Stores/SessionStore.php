<?php

declare(strict_types=1);

namespace Honed\Refine\Stores;

use Illuminate\Contracts\Session\Session;

class SessionStore extends Store
{
    const NAME = 'session';
    
    public function __construct(
        protected Session $session,
    ) {}

    /**
     * Retrieve the data from the store and put it in memory.
     *
     * @return $this
     */
    public function resolve(): self
    {
        $this->resolved = $this->session->get($this->key, []);

        return $this;
    }

    /**
     * Set the session to use for the store.
     *
     * @param  Session  $session
     * @return $this
     */
    public function session(Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Persist the data to the session.
     *
     * @return void
     */
    public function persist(): void
    {
        match (true) {
            empty($this->data) => $this->session->forget($this->key),
            default => $this->session->put($this->key, $this->data),
        };
    }
}
