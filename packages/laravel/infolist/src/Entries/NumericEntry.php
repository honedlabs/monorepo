<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\NumericFormatter;

/**
 * @extends Entry<mixed, string>
 */
class NumericEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('numeric');

        $this->formatter(NumericFormatter::class);
    }
}
