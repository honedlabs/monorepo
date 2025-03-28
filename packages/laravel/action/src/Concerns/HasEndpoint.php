<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

trait HasEndpoint
{
    /**
     * The endpoint to execute server actions.
     *
     * @var string|null
     */
    protected $endpoint;

    /**
     * Set the endpoint to execute server actions.
     *
     * @param  string|null  $endpoint
     * @return $this
     */
    public function endpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get the endpoint to execute server actions.
     *
     * @return string|null
     */
    public function getEndpoint()
    {
        return $this->endpoint ?? static::getDefaultEndpoint();
    }

    /**
     * Get the default endpoint to execute server actions.
     *
     * @return string|null
     */
    public static function getDefaultEndpoint()
    {
        /** @var string|null */
        return config('action.endpoint', '/actions');
    }

    /**
     * Determine if the action has an endpoint.
     *
     * @return bool
     */
    public function hasEndpoint(): bool
    {
        return isset($this->endpoint);
    }
}
