<?php

declare(strict_types=1);

namespace Honed\Persist\Drivers;

use Illuminate\Contracts\Session\Session;

class SessionDriver extends Driver
{
    public const NAME = 'session';

    /**
     * The session to use for the driver.
     *
     * @var Session
     */
    protected $session;

    public function __construct(
        string $name,
        string $key,
        Session $session,
    ) {
        parent::__construct($name, $key);

        $this->session = $session;
    }

    /**
     * Retrieve the data from the driver and put it in memory.
     *
     * @return $this
     */
    public function resolve(): self
    {
        /** @var array<string,mixed>|null $data */
        $data = $this->session->get($this->key, []);

        if (is_array($data)) {
            $this->resolved = $data;
        }

        return $this;
    }

    /**
     * Persist the data to the session.
     */
    public function persist(): void
    {
        match (true) {
            empty($this->data) => $this->session->forget($this->key),
            default => $this->session->put($this->key, $this->data),
        };
    }

    /**
     * Set the session to use for the driver.
     *
     * @return $this
     */
    public function session(Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get the session being used by the driver.
     *
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }
}
