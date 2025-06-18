<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Illuminate\Support\Facades\Storage;

trait CanBeImage
{
    public const IMAGE = 'image';

    /**
     * The disk to be used to retrieve the image from.
     *
     * @var string|null
     */
    protected $disk = null;

    /**
     * The shape of the image.
     *
     * @var string|null
     */
    protected $shape = null;

    /**
     * Whether to create a temporary file url for the image.
     *
     * @var int
     */
    protected $temporary = 0;

    /**
     * Set the disk to be used to retrieve the image from.
     *
     * @param  string  $disk
     * @return $this
     */
    public function disk($disk = 's3')
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Get the disk to be used to retrieve the image from.
     *
     * @return string|null
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * Set whether the image should be displayed as a square.
     *
     * @param  string  $shape
     * @return $this
     */
    public function shape($shape = 'square')
    {
        $this->shape = $shape;

        return $this;
    }

    /**
     * Set the shape of the image to square.
     *
     * @return $this
     */
    public function square()
    {
        return $this->shape('square');
    }

    /**
     * Set the shape of the image to circular.
     *
     * @return $this
     */
    public function circular()
    {
        return $this->shape('circle');
    }

    /**
     * Get the shape of the image.
     *
     * @return string|null
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * Set whether to create a temporary file url for the image.
     *
     * @param  int  $minutes
     * @return $this
     */
    public function temporaryUrl($minutes = 5)
    {
        $this->temporary = $minutes;

        return $this;
    }

    /**
     * Determine if a temporary file url should be created for the image.
     *
     * @return bool
     */
    public function isTemporaryUrl()
    {
        return (bool) $this->temporary;
    }

    /**
     * Get the duration of the temporary file url.
     *
     * @return int
     */
    public function getUrlDuration()
    {
        return $this->temporary;
    }

    /**
     * Format the image value.
     *
     * @param  string|null  $value
     * @return string|null
     */
    protected function formatImage($value)
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
