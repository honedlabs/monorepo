<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\ImageFormatter;

/**
 * @extends Entry<string, string>
 */
class ImageEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('image');

        $this->formatter(ImageFormatter::class);
    }
}
