<?php

declare(strict_types=1);

namespace Honed\Persist\Drivers;

use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

class CookieDriver extends Driver
{
    public const NAME = 'cookie';

    /**
     * The cookie jar to use for the driver.
     *
     * @var CookieJar
     */
    protected $cookieJar;

    /**
     * The request to use for the driver.
     *
     * @var Request
     */
    protected $request;

    /**
     * The default lifetime for the cookie.
     *
     * @var int
     */
    protected $lifetime = 31536000;

    /**
     * Create a new cookie driver instance.
     */
    public function __construct(
        string $name,
        string $key,
        CookieJar $cookieJar,
        Request $request,
    ) {
        parent::__construct($name, $key);

        $this->cookieJar = $cookieJar;
        $this->request = $request;
    }

    /**
     * Retrieve the data from the driver and driver it in memory.
     *
     * @return $this
     */
    public function resolve(): self
    {
        /** @var array<string,mixed>|null $data */
        $data = json_decode(
            $this->request->cookie($this->key, '[]'), true // @phpstan-ignore argument.type
        );

        if (is_array($data)) {
            $this->resolved = $data;
        }

        return $this;
    }

    /**
     * Persist the data to a cookie.
     */
    public function persist(): void
    {
        match (true) {
            empty($this->data) => $this->cookieJar->forget($this->key),
            default => $this->cookieJar->queue(
                $this->key, json_encode($this->data, JSON_THROW_ON_ERROR), $this->lifetime
            ),
        };
    }

    /**
     * Set the request to use for the driver.
     *
     * @return $this
     */
    public function request(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the request to use for the driver.
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Set the cookie jar to use for the driver.
     *
     * @return $this
     */
    public function cookieJar(CookieJar $cookieJar): self
    {
        $this->cookieJar = $cookieJar;

        return $this;
    }

    /**
     * Get the cookie jar to use for the driver.
     */
    public function getCookieJar(): CookieJar
    {
        return $this->cookieJar;
    }

    /**
     * Set the lifetime for the cookie.
     *
     * @return $this
     */
    public function lifetime(int $seconds): self
    {
        $this->lifetime = $seconds;

        return $this;
    }

    /**
     * Get the lifetime for the cookie.
     */
    public function getLifetime(): int
    {
        return $this->lifetime;
    }
}
