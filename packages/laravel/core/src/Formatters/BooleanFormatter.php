<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

use Honed\Core\Contracts\Formats;

class BooleanFormatter implements Formats
{
    /**
     * @var string
     */
    protected $true = 'True';

    /**
     * @var string
     */
    protected $false = 'False';

    public function __construct(?string $true = null, ?string $false = null)
    {
        $this->true($true);
        $this->false($false);
    }

    /**
     * Make a new boolean formatter.
     *
     * @return $this
     */
    public static function make(?string $true = null, ?string $false = null): static
    {
        return resolve(static::class, compact('true', 'false'));
    }

    /**
     * Set the truth and false labels, chainable.
     *
     * @return $this
     */
    public function labels(?string $true = null, ?string $false = null): static
    {
        $this->true($true);
        $this->false($false);

        return $this;
    }

    /**
     * Set the true label for the instance.
     *
     * @return $this
     */
    public function true(?string $true): static
    {
        if (! \is_null($true)) {
            $this->true = $true;
        }

        return $this;
    }

    /**
     * Get the true label for the instance.
     */
    public function getTrue(): string
    {
        return $this->true;
    }

    /**
     * Set the false label for the instance.
     *
     * @return $this
     */
    public function false(?string $false): static
    {
        if (! \is_null($false)) {
            $this->false = $false;
        }

        return $this;
    }

    /**
     * Get the false label for the instance.
     */
    public function getFalse(): string
    {
        return $this->false;
    }

    /**
     * Format the value as a boolean label.
     */
    public function format(mixed $value): string
    {
        return ((bool) $value)
            ? $this->getTrue()
            : $this->getFalse();
    }
}
