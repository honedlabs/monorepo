<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\TextFormatter;

/**
 * @extends Entry<mixed, string|array<int, string>>
 */
class TextEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('text');

        $this->formatter(TextFormatter::class);
    }
}
