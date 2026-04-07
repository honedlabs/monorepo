<?php

declare(strict_types=1);

namespace Honed\Chart\Proxies;

use Honed\Chart\Chartable;

/**
 * @template TSource of \Honed\Chart\Chartable
 * @template TProxy of \Honed\Chart\Chartable
 */
class HigherOrderProxy
{
    /**
     * @param  TSource  $source
     * @param  TProxy  $proxy
     */
    public function __construct(
        protected Chartable $source,
        protected Chartable $proxy,
    ) {}

    /**
     * Forward a method call to the proxy.
     *
     * @param  array<int, mixed>  $parameters
     */
    public function __call(string $method, array $parameters): mixed
    {
        $result = $this->proxy->$method(...$parameters);

        return $result === $this->proxy ? $this->source : $result;
    }

    /**
     * Get the source object.
     */
    public function getSource(): Chartable
    {
        return $this->source;
    }

    /**
     * Get the proxy itself.
     */
    public function getProxy(): Chartable
    {
        return $this->proxy;
    }
}
