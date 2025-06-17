<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Illuminate\Support\Facades\Storage;

trait CanBeImage
{
    public const IMAGE = 'image';

    /**
     * The disk to be used to retrieve the image from.
     */
    protected ?string $disk = null;

    /**
     * The shape of the image.
     */
    protected ?string $shape = null;

    /**
     * Whether to create a temporary file url for the image.
     */
    protected int $temporary = 0;

    /**
     * Set the disk to be used to retrieve the image from.
     *
     * @return $this
     */
    public function disk(string $disk = 's3'): static
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Get the disk to be used to retrieve the image from.
     */
    public function getDisk(): ?string
    {
        return $this->disk;
    }

    /**
     * Set whether the image should be displayed as a square.
     *
     * @return $this
     */
    public function shape(string $shape = 'square'): static
    {
        $this->shape = $shape;

        return $this;
    }

    /**
     * Set the shape of the image to square.
     *
     * @return $this
     */
    public function square(): static
    {
        return $this->shape('square');
    }

    /**
     * Set the shape of the image to circular.
     *
     * @return $this
     */
    public function circular(): static
    {
        return $this->shape('circle');
    }

    /**
     * Get the shape of the image.
     */
    public function getShape(): ?string
    {
        return $this->shape;
    }

    /**
     * Set whether to create a temporary file url for the image.
     *
     * @return $this
     */
    public function temporaryUrl(int $minutes = 5): static
    {
        $this->temporary = $minutes;

        return $this;
    }

    /**
     * Determine if a temporary file url should be created for the image.
     */
    public function isTemporaryUrl(): bool
    {
        return (bool) $this->temporary;
    }

    /**
     * Get the duration of the temporary file url.
     */
    public function getUrlDuration(): int
    {
        return $this->temporary;
    }

    /**
     * Format the image value.
     *
     * @param  string|null  $value
     */
    protected function formatImage(mixed $value): ?string
    {
        $driver = $this->getDisk();

        if (! $driver || is_null($value)) {
            return $value;
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter */
        $disk = Storage::disk($driver);

        return match (true) {
            $this->isTemporaryUrl() => $disk->temporaryUrl(
                $value, now()->addMinutes($this->getUrlDuration())
            ),
            default => $disk->url($value),
        };
    }
}
