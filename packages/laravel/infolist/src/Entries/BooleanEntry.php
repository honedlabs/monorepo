<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\BooleanFormatter;

/**
 * @extends Entry<mixed, string>
 */
class BooleanEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('boolean');

        $this->formatter(BooleanFormatter::class);
    }
}
