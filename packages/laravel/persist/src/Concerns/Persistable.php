<?php

declare(strict_types=1);

namespace Honed\Persist\Concerns;

use Illuminate\Support\Str;

/**
 * @implements \Honed\Persist\Contracts\CanPersistData
 */
trait Persistent
{
    /**
     * The name of the key when persisting data.
     *
     * @var string|null
     */
    protected $persistKey = null;

    /**
     * The default store to use for persisting data.
     *
     * @var string
     */
    protected $store = SessionStore::NAME;

    /**
     * Get the request to use for the store.
     *
     * @return \Illuminate\Http\Request
     */
    abstract public function getRequest();

    /**
     * Set the name of the key to use when persisting data to a store.
     *
     * @param  string  $key
     * @return $this
     */
    public function persistKey($key)
    {
        $this->persistKey = $key;

        return $this;
    }

    /**
     * Get the name of the key to use when persisting data.
     *
     * @return string
     */
    public function getPersistKey()
    {
        return $this->persistKey ??= $this->guessPersistKey();
    }

    /**
     * Set the store to use for persisting data by default.
     *
     * @param  string  $store
     * @return $this
     */
    public function persistIn($store)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Set the store to use for persisting data to the session.
     *
     * @return $this
     */
    public function persistInSession()
    {
        return $this->persistIn(SessionStore::NAME);
    }

    /**
     * Set the store to use for persisting data to the cookie.
     *
     * @return $this
     */
    public function persistInCookie()
    {
        return $this->persistIn(CookieDriver::NAME);
    }

    public function persistInDatabase()
    {
        return $this->persistIn(DatabaseStore::NAME);
    }

    /**
     * Set the time to live for the persistent data, if using the cookie store.
     *
     * @param  int  $seconds
     * @return $this
     */
    public function lifetime($seconds = 15724800)
    {
        /** @var CookieStore $store */
        $store = $this->getStore(CookieStore::NAME);

        $store->lifetime($seconds);

        return $this;
    }

    /**
     * Get the stores to use for persisting data.
     *
     * @return array<string,\Honed\Refine\Stores\Store>
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * Get the store to use for persisting data.
     *
     * @param  bool|string|null  $type
     * @return Store|null
     */
    public function getStore($type = null)
    {
        if ($type === true) {
            $type = $this->store;
        }

        return match ($type) {
            CookieStore::NAME => $this->newCookieStore(),
            SessionStore::NAME => $this->newSessionStore(),
            default => null,
        };
    }

    /**
     * Guess the name of the key to use when persisting data.
     *
     * @return string
     */
    protected function guessPersistKey()
    {
        return Str::of(static::class)
            ->classBasename()
            ->snake('-')
            ->toString();
    }
}
