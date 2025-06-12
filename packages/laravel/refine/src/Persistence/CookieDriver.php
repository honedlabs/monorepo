<?php

namespace Honed\Refine\Persistence;

use Illuminate\Contracts\Session\Session;
use Illuminate\Cookie\CookieJar;

class CookieDriver extends Driver
{
    public function __construct(
        protected CookieJar $cookieJar,
    ) { }

    /**
     * Retrieve the data from the driver and store it in memory.
     * 
     * @return void
     */
    public function resolve()
    {
        $this->resolvedData = [];
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