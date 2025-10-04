<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Contracts\Formatter;
use Illuminate\Support\Facades\Storage;

/**
 * @implements Formatter<string, string>
 */
class ImageFormatter implements Formatter
{
    /**
     * The disk to be used to retrieve the image.
     *
     * @var string|null
     */
    protected $disk;

    /**
     * The expiry time for the image URL.
     *
     * @var int|null
     */
    protected $expires;

    /**
     * Set the disk to be used to retrieve the image.
     *
     * @return $this
     */
    public function disk(string $value = 's3'): static
    {
        $this->disk = $value;

        return $this;
    }

    /**
     * Get the disk to be used to retrieve the image.
     */
    public function getDisk(): ?string
    {
        return $this->disk;
    }

    /**
     * Set the expiry time for the image URL in minutes.
     *
     * @return $this
     */
    public function expiresIn(int $minutes): static
    {
        $this->expires = $minutes;

        return $this;
    }

    /**
     * Get the expiry time for the image URL in minutes.
     */
    public function getExpiry(): ?int
    {
        return $this->expires;
    }

    /**
     * Format the value as an image.
     *
     * @param  string|null  $value
     * @return string|null
     */
    public function format(mixed $value): mixed
    {
        $disk = $this->getDisk();

        if (is_null($disk) || is_null($value)) {
            return $value;
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter */
        $disk = Storage::disk($disk);

        $expires = $this->getExpiry();

        return match (true) {
            ! is_null($expires) && $expires > 0 => $disk->temporaryUrl(
                $value, now()->addMinutes($expires)
            ),
            default => $disk->url($value),
        };
    }
}
