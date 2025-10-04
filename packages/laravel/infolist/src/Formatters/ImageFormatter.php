<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Contracts\Formatter;
use Illuminate\Support\Facades\Storage;

/**
 * @implements Formatter<mixed, mixed>
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
     * Format the value as an image.
     * 
     * @param mixed $value
     * @return mixed
     */
    public function format(mixed $value): mixed
    {
        $disk = $this->getDisk();

        if (is_null($disk) || is_null($value)) {
            return $value;
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter */
        $disk = Storage::disk($disk);

        $expires = $this->getExpires();

        return match (true) {
            $this->isTemporaryUrl() => $disk->temporaryUrl(
                $value, now()->addMinutes($this->getUrlDuration())
            ),
            default => Storage::disk($disk)->url($value),
        };
    }
}