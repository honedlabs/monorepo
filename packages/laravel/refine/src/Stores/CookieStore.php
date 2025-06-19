<?php

declare(strict_types=1);

namespace Honed\Refine\Stores;

use Illuminate\Contracts\Session\Session;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

class CookieStore extends Store
{
    const NAME = 'cookie';

    /**
     * The default lifetime for the cookie.
     *
     * @var int
     */
    protected $lifetime = 31536000;

    public function __construct(
        protected CookieJar $cookieJar,
        protected Request $request,
    ) {}

    /**
     * Retrieve the data from the store and store it in memory.
     *
     * @return $this
     */
    public function resolve(): self
    {
        $this->resolved = json_decode(
            $this->request->cookie($this->key, '[]'), true // @phpstan-ignore argument.type
        );

        return $this;
    }

    /**
     * Set the request to use for the store.
     *
     * @param  Request  $request
     * @return $this
     */
    public function request(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Set the cookie jar to use for the store.
     *
     * @param  CookieJar  $cookieJar
     * @return $this
     */
    public function cookieJar(CookieJar $cookieJar): self
    {
        $this->cookieJar = $cookieJar;

        return $this;
    }

    /**
     * Set the lifetime for the cookie.
     *
     * @param  int  $seconds
     * @return $this
     */
    public function lifetime(int $seconds): self
    {
        $this->lifetime = $seconds;

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
            empty($this->data) => $this->cookieJar->forget($this->key),
            default => $this->cookieJar->queue(
                $this->key, json_encode($this->data), $this->lifetime
            ),
        };
    }
}
