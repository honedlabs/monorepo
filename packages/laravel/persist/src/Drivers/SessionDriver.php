<?php

declare(strict_types=1);

namespace Honed\Persist\Drivers;

use Illuminate\Contracts\Session\Session;

class SessionDriver extends Driver
{
    /**
     * The session to use for the driver.
     *
     * @var Session
     */
    protected $session;

    public function __construct(
        string $name,
        Session $session,
    ) {
        parent::__construct($name);

        $this->session = $session;
    }

    /**
     * Retrieve the data from the driver and put it in memory.
     *
     * @return array<string,mixed>
     */
    public function value(string $scope): array
    {
        /** @var array<string,mixed>|null $data */
        $data = $this->session->get($scope, []);

        return $data ?? [];
    }

    /**
     * Persist the data to the session.
     */
    public function persist(string $scope): void
    {
        match (true) {
            empty($this->data) => $this->session->forget($scope),
            default => $this->session->put($scope, $this->data),
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
     */
    public function getSession(): Session
    {
        return $this->session;
    }
}
