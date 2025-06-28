<?php

declare(strict_types=1);

namespace Honed\Refine\Contracts;

interface CanPersistData
{
    /**
     * Get the name of the key to use when persisting data.
     *
     * @return string
     */
    public function getPersistKey();

    /**
     * Get the store to use for persisting data.
     *
     * @param  bool|string|null  $type
     * @return Store|null
     */
    public function getStore($type = null);
}