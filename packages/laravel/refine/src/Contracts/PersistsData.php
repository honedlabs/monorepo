<?php

namespace Honed\Refine\Contracts;

interface PersistsData
{
    /**
     * Get the value for the given key stored by the driver.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key);

    /**
     * Forget the value for the given key stored by the driver in preparation to
     * persist it.
     *
     * @param  string  $key
     * @return void
     */
    public function forget($key);

    /**
     * Put the value for the given key stored by the driver in preparation to
     * persist it.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function put($key, $value);

    /**
     * Persist the data to the driver.
     * 
     * @return void
     */
    public function persist();
}