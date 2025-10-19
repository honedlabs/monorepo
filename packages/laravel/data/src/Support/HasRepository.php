<?php

declare(strict_types=1);

namespace Honed\Data\Support;

use Illuminate\Contracts\Cache\Repository;

abstract class HasRepository
{
    /**
     * The driver name.
     */
    public ?string $driver = null;

    /**
     * Get the cache repository.
     */
    public function getRepository(): Repository
    {
        /** @var Repository */
        return app('cache')->store($this->driver);
    }
}
