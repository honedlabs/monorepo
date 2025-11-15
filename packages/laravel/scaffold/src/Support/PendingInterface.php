<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Honed\Core\Concerns\HasName;
use Honed\Scaffold\Concerns\Annotatable;

class PendingInterface extends PendingHelper
{
    use Annotatable;
    use HasName;
}
