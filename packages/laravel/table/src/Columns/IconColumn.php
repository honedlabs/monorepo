<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

use Closure;
use Honed\Core\Concerns\HasIcon;

class IconColumn extends Column
{
    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->type(self::ICON);
    }
}
