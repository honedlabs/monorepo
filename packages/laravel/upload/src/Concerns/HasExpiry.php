<?php

declare(strict_types=1);

namespace Honed\Upload\Concerns;

trait HasExpiry
{
    /**
     * The expiry duration of the request in seconds.
     * 
     * @var int|null
     */
    protected $expires;

    /**
     * Set the expiry duration of the request in seconds.
     * 
     * @param int $seconds
     * @return $this
     */
    public function expiresIn($seconds)
    {
        $this->expires = $seconds;

        return $this;
    }

    /**
     * Get the expiry duration of the request in seconds.
     * 
     * @return int
     */
    public function getExpiry()
    {
        return $this->expires ?? static::getDefaultExpiry();
    }

    /**
     * Get the default expiry duration of the request in seconds.
     * 
     * @return int
     */
    public static function getDefaultExpiry()
    {
        return type(config('upload.expires', 120))->asInt();
    }

    /**
     * Format the expiry duration of the request.
     * 
     * @return string
     */
    public function formatExpiry()
    {
        return \sprintf('+%d seconds', \abs($this->getExpiry()));
    }
    
}
