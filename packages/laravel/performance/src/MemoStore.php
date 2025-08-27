<?php

declare(strict_types=1);

namespace Honed\Memo;

use Illuminate\Contracts\Cache\Repository;

class MemoStore implements Repository
{
    public function __construct(
        protected Repository $store
    ) {}


}