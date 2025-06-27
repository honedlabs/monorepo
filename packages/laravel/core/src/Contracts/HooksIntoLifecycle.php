<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface HooksIntoLifecycle
{
    /**
     * Set a callback to be called after the pipeline has finished.
     * 
     * @param  (\Closure(mixed...):mixed|void)|null  $callback
     * @return $this
     */
    public function after($callback);

    /**
     * Get the callback to be called after the pipeline has finished.
     * 
     * @return (\Closure(mixed...):mixed|void)|null
     */
    public function afterCallback();

    /**
     * Call the after callback.
     * 
     * @return mixed
     */
    public function callAfter();

    /**
     * Set a callback to be called before the pipeline has begun.
     * 
     * @param  (\Closure(mixed...):mixed|void)|null  $callback
     * @return $this
     */
    public function before($callback);

    /**
     * Get the callback to be called before the pipeline has begun.
     * 
     * @return (\Closure(mixed...):mixed|void)|null
     */
    public function beforeCallback();

    /**
     * Call the before callback.
     * 
     * @return mixed
     */
    public function callBefore();
}