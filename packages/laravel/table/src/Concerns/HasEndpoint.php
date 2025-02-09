<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

trait HasEndpoint
{
    /**
     * @var string|null
     */
    protected $endpoint;

    /**
     * Get the endpoint to be used for table actions.
     */
    public function getEndpoint(): string
    {
        return match (true) {
            \property_exists($this, 'endpoint') && !\is_null($this->endpoint) => $this->endpoint,
            \method_exists($this, 'endpoint') => $this->endpoint($this),
            default => config('table.endpoint', '/actions'),
        };
    }
}
