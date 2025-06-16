<?php

declare(strict_types=1);

namespace Honed\List\Entries\Concerns;

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
     * The alt text to be used for the image.
     * 
     * @var string|\Closure|null
     */
    protected string|\Closure|null $alt;

    /**
     * Whether lazy loading should be used for the image.
     * 
     * @var bool
     */
    protected bool $isLazy = false;

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
     * Set the alt text to be used for the image.
     * 
     * @param  string|\Closure  $alt
     * @return $this
     */
    public function alt(string|\Closure $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get the alt text to be used for the image.
     * 
     * @return string|\Closure|null
     */
    public function getAlt(): string|\Closure|null
    {
        return $this->evaluate($this->alt);
    }

    /**
     * Determine if alt text is set.
     * 
     * @return bool
     */
    public function hasAlt(): bool
    {
        return isset($this->alt);
    }

    /**
     * Set whether lazy loading should be used for the image.
     * 
     * @param  bool  $isLazy
     * @return $this
     */
    public function lazy(bool $isLazy = true): static
    {
        $this->isLazy = $isLazy;

        return $this;
    }

    /**
     * Get whether lazy loading should be used for the image.
     * 
     * @return bool
     */
    public function isLazy(): bool
    {
        return $this->isLazy;
    }
}