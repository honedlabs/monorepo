<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\CanHaveAlias;
use Honed\Core\Concerns\CanHaveExtra;

class Entry extends BaseEntry
{
    use Allowable;
    use CanHaveExtra;
    use CanHaveAlias;
    use Concerns\CanBeAggregated;
}
