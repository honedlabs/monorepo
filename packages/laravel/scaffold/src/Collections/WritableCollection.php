<?php

declare(strict_types=1);

namespace Honed\Scaffold\Collections;

use Honed\Scaffold\Contracts\Scaffolder;
use Honed\Scaffold\Support\ScaffoldContext;
use Honed\Scaffold\Support\Utility\Writer;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Support\Collection<int, \Honed\Scaffold\Concerns\Writable>
 */
class WritableCollection extends Collection
{
    public function newLine(): static
    {
        return $this;
    }

    public function write()
    {
        return implode(
            PHP_EOL,
            $this->map(fn ($writable) => $writable->write())->all()
        );
    }
    
}
