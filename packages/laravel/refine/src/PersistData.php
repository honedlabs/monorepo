<?php

declare(strict_types=1);

namespace Honed\Refine;

use Honed\Core\Concerns\HasRequest;
use Illuminate\Contracts\Session\Session;
use Illuminate\Cookie\CookieJar;

class PersistData
{
    public const SESSION = 'session';
    public const COOKIE = 'cookie';

    /**
     * The key to use for the persistence.
     *
     * @var string
     */
    protected $key;

    /**
     * The default driver to use for the persistence.
     *
     * @var 'session'|'cookie'
     */
    protected $driver = self::SESSION;

    /**
     * The data to persist.
     *
     * @var array<string,mixed>
     */
    protected $data = [];

    public function __construct(
        protected CookieJar $cookieJar,
        protected Session $session,
    ) {}

    public static function make($key, $driver = self::SESSION)
    {
        return resolve(static::class)
            ->key($key)
            ->driver($driver);
    }

    /**
     * Get the value for the given key in the namespace.
     *
     * @param  mixed  $key
     * @param  'session'|'cookie'  $driver
     * @return mixed
     */
    public function get($key, $driver = null)
    {
        $driver = $driver ?? $this->driver;

        return $this->$driver->get($key);
    }

    /**
     * Put the value for the given key in the namespace.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @param  'session'|'cookie'  $driver
     * @return mixed
     */
    protected function put($key, $value, $driver = null)
    {
        $driver = $this->getDriver($driver);

        return $driver->put($key, $value);
    }

    /**
     * Persist the data in their respective drivers.
     * 
     * @return void
     */
    public function persist()
    {
        $this->persistToSession();
        $this->persistToCookie();
    }

    /**
     * Persist the data to the session.
     *
     * @return void
     */
    protected function persistToSession()
    {
        match (true) {
            ! filled($this->sessionData) => $this->session->forget($this->key),
            default => $this->session->put($this->key, $this->sessionData),
        };
    }

    /**
     * Persist the data to the cookie.
     *
     * @return void
     */
    protected function persistToCookie()
    {
        match (true) {
            ! filled($this->cookieData) => $this->cookieJar->forget($this->key),
            default => $this->cookieJar->queue(
                $this->key,
                json_encode($this->cookieData),
                $this->cookieLifetime
            ),
        };
    }
}
