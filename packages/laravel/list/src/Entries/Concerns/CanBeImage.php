<?php

declare(strict_types=1);

namespace Honed\List\Entries\Concerns;

use Illuminate\Support\Facades\Storage;

trait CanBeImage
{
    /**
     * The disk to be used to retrieve the image from.
     * 
     * @var string|null
     */
    protected ?string $disk;

    /**
     * Whether the image should be displayed as a square.
     * 
     * @var bool
     */
    protected bool $isSquare = false;

    /**
     * Whether to create a temporary file url for the image.
     * 
     * @var int
     */
    protected int $temporary = 0;

    /**
     * Set the disk to be used to retrieve the image from.
     * 
     * @param  string  $disk
     * @return $this
     */
    public function disk(string $disk): static
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Get the disk to be used to retrieve the image from.
     * 
     * @return string|null
     */
    public function getDisk(): ?string
    {
        return $this->disk;
    }

    /**
     * Determine if a disk is set.
     * 
     * @return bool
     */
    public function hasDisk(): bool
    {
        return isset($this->disk);
    }

    /**
     * Set whether the image should be displayed as a square.
     * 
     * @param  bool  $isSquare
     * @return $this
     */
    public function square(bool $isSquare = true): static
    {
        $this->isSquare = $isSquare;

        return $this;
    }

    /**
     * Set whether the image should be displayed as a circle.
     * 
     * @param  bool  $isCircle
     * @return $this
     */
    public function circular(bool $circular = true): static
    {
        return $this->square(! $circular);
    }

    /**
     * Get whether the image should be displayed as a square.
     * 
     * @return bool
     */
    public function isSquare(): bool
    {
        return $this->isSquare;
    }

    /**
     * Get whether the image should be displayed as a circle.
     * 
     * @return bool
     */
    public function isCircular(): bool
    {
        return ! $this->isSquare();
    }

    /**
     * Set whether to create a temporary file url for the image.
     * 
     * @param  int  $minutes
     * @return $this
     */
    public function temporaryUrl(int $minutes = 5): static
    {
        $this->temporary = $minutes;

        return $this;
    }

    /**
     * Determine if a temporary file url should be created for the image.
     * 
     * @return bool
     */
    public function isTemporaryUrl(): bool
    {
        return (bool) $this->temporary;
    }

    /**
     * Get the duration of the temporary file url.
     * 
     * @return int
     */
    public function getUrlDuration(): int
    {
        return $this->temporary;
    }

    /**
     * Format the image value.
     */
    protected function formatImage(mixed $value): string
    {
        if (! $this->hasDisk()) {
            return $value;
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter */
        $disk = Storage::disk($this->getDisk());

        return match (true) {
            $this->isTemporaryUrl() => $disk->temporaryUrl(
                $value, now()->addMinutes($this->getUrlDuration())
            ),
            default => $disk->url($value),
        };
    }
}