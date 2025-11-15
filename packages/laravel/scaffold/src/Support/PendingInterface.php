<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Honed\Core\Concerns\HasName;
use Honed\Scaffold\Concerns\Annotatable;
use Honed\Scaffold\Support\Utility\Writer;

class PendingInterface extends PendingHelper
{
    use HasName;
    use Annotatable;
}
