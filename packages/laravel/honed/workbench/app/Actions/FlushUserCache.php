<?php

declare(strict_types=1);

namespace Honed\Honed\Actions;

use Honed\Action\Contracts\Action;
use Honed\Honed\Actions\FlushCache;
use Workbench\App\Caches\UserCache;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TInput of \Workbench\App\Models\User
 */
class FlushUserCache extends FlushCache
{
    /**
     * {@inheritdoc}
     */
    public function cache(): string
    {
        return UserCache::class;
    }
}
