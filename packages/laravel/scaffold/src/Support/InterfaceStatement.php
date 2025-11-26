<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Honed\Core\Concerns\HasName;
use Honed\Scaffold\Concerns\Annotatable;
use Honed\Scaffold\Support\Utility\Writer;

class InterfaceStatement
{
    use Annotatable;
    use HasName;

    public function write(Writer $writer)
    {
        return $writer;
    }
}
