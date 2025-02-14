<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

trait HasEndpoint
{
    const Endpoint = '/actions';

    /**
     * The endpoint to be used to handle table actions.
     * 
     * @var string|null
     */
    protected $endpoint;

    /**
     * The default endpoint to be used for all tables.
     * 
     * @var string
     */
    protected static $defaultEndpoint = self::Endpoint;

    /**
     * Get the endpoint to be used for table actions.
     */
    public function getEndpoint(): string
    {
        return match (true) {
            isset($this->endpoint) => $this->endpoint,
            \method_exists($this, 'endpoint') => $this->endpoint(),
            default => static::getDefaultEndpoint(),
        };
    }

    public static function useEndpoint(string $endpoint): void
    {
        static::$defaultEndpoint = $endpoint;
    }

    public static function getDefaultEndpoint(): string
    {
        return static::$defaultEndpoint;
    }
}
