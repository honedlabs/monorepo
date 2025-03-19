<?php

declare(strict_types=1);

namespace Honed\Core;

use Honed\Core\Concerns\InterpretsRequest;

class Interpret
{
    use InterpretsRequest {
        interpretArray as array;
        interpretBoolean as boolean;
        interpretCollection as collection;
        interpretDate as date;
        interpretFloat as float;
        interpretInteger as integer;
        interpretRaw as raw;
        interpretString as string;
        interpretStringable as stringable;
    }
}
