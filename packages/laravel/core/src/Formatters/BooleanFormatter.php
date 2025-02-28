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
     * Make a new boolean formatter.
     *
     * @param  string|null  $true
     * @param  string|null  $false
     * @return static
     */
    public static function make($true = null, $false = null)
    {
        return resolve(static::class)
            ->true($true)
            ->false($false);
    }

    /**
     * Set the truth and false labels, chainable.
     *
     * @param  string|null  $true
     * @param  string|null  $false
     * @return $this
     */
    public function labels($true = null, $false = null)
    {
        $this->true($true);
        $this->false($false);

        return $this;
    }

    /**
     * Set the true label for the instance.
     *
     * @param  string|null  $true
     * @return $this
     */
    public function true($true = null)
    {
        if (! \is_null($true)) {
            $this->true = $true;
        }

        return $this;
    }

    /**
     * Get the true label for the instance.
     *
     * @return string
     */
    public function getTrue()
    {
        return $this->true;
    }

    /**
     * Set the false label for the instance.
     *
     * @param  string|null  $false
     * @return $this
     */
    public function false($false = null)
    {
        if (! \is_null($false)) {
            $this->false = $false;
        }

        return $this;
    }

    /**
     * Get the false label for the instance.
     *
     * @return string
     */
    public function getFalse()
    {
        return $this->false;
    }

    /**
     * Format the value as a boolean label.
     *
     * @param  mixed  $value
     * @return string
     */
    public function format($value)
    {
        return ((bool) $value)
            ? $this->getTrue()
            : $this->getFalse();
    }
}
