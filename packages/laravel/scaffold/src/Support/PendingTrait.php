<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Honed\Core\Concerns\HasName;
use Honed\Scaffold\Concerns\Annotatable;

class PendingTrait
{
    use Annotatable;
    use HasName;

    public function write(Writer $writer)
    {
        return $writer
            // ->import($this->getName())
            ->line("use {$this->getName()};");
    }
}
