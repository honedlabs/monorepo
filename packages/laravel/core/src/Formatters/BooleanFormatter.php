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

    /**
     * Create a new boolean formatter instance.
     * 
     * @param string|null $true
     * @param string|null $false
     */
    public function __construct($true = null, $false = null)
    {
        $this->true($true);
        $this->false($false);
    }

    /**
     * Make a new boolean formatter.
     * 
     * @param string|null $true
     * @param string|null $false
     * 
     * @return $this
     */
    public static function make($true = null, $false = null)
    {
        return resolve(static::class, compact('true', 'false'));
    }

    /**
     * Set the truth and false labels, chainable.
     *
     * @param string|null $true
     * @param string|null $false
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
     * Get or set the true label for the instance.
     * 
     * @param string|null $true The true label to set, or null to retrieve the current true label.
     * @return string|$this The current true label when no argument is provided, or the instance when setting the true label.
     */
    public function true($true = null)
    {
        if (\is_null($true)) {
            return $this->true;
        }

        $this->true = $true;

        return $this;
    }

    /**
     * Get or set the false label for the instance.
     * 
     * @param string|null $false The false label to set, or null to retrieve the current false label.
     * @return string|$this The current false label when no argument is provided, or the instance when setting the false label.
     */
    public function false($false = null)
    {
        if (\is_null($false)) {
            return $this->false;
        }

        $this->false = $false;

        return $this;
    }

    /**
     * Format the value as a boolean.
     * 
     * @param mixed $value
     * @return string
     */
    public function format($value): string
    {
        return ((bool) $value) 
            ? $this->true() 
            : $this->false();
    }
}
