<?php

namespace Honed\Refine\Persistence;

use Illuminate\Contracts\Session\Session;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

class CookieDriver extends Driver
{
    /**
     * The default lifetime for the cookie.
     *
     * @var int
     */
    protected $lifetime = 31536000;

    public function __construct(
        protected CookieJar $cookieJar,
        protected Request $request,
    ) { }

    /**
     * Retrieve the data from the driver and store it in memory.
     * 
     * @return void
     */
    public function resolve()
    {
        $this->resolvedData = $this->request->cookie($this->key, []);
    }

    /**
     * Set the request to use for the driver.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $this
     */
    public function request($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Set the cookie jar to use for the driver.
     *
     * @param  \Illuminate\Cookie\CookieJar  $cookieJar
     * @return $this
     */
    public function cookieJar($cookieJar)
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
    public function lifetime($seconds)
    {
        $this->lifetime = $seconds;

        return $this;
    }

    /**
     * Persist the data to the session.
     * 
     * @return void
     */
    public function persist()
    {
        match (true) {
            empty($this->data) => $this->cookieJar->forget($this->key),
            default => $this->cookieJar->put($this->key, $this->data),
        };
    }
}