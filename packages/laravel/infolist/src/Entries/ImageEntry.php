<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\ImageFormatter;

/**
 * @extends Entry<string, string>
 *
 * @method $this disk(string $value = 's3') Set the disk to be used to retrieve the image.
 * @method string|null getDisk() Get the disk to be used to retrieve the image.
 * @method $this expiresIn(int $minutes) Set the expiry time for the image URL in minutes.
 * @method int|null getExpiry() Get the expiry time for the image URL in minutes.
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
