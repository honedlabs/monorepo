<?php

declare(strict_types=1);

namespace Honed\Core;

use Symfony\Component\HttpFoundation\Request;

class Destination extends Primitive
{
    /**
     * Indicate that for a signed link, it does not expire
     */
    const DoesntExpire = 0;

    /**
     * @var string
     */
    protected $destination;

    /**
     * @var \Closure
     */
    protected $resolver;

    /**
     * @var mixed
     */
    protected $parameters = [];

    /**
     * @var string
     */
    protected $how = Request::METHOD_GET;

    /**
     * @var bool
     */
    protected $signed = false;

    /**
     * @var bool
     */
    protected $newTab = false;

    /**
     * @var bool
     */
    protected $download = false;

    /**
     * @var int|null
     */
    protected $duration = null;

    /**
     * Create a new destination instance.
     * 
     * @param mixed $destination
     */
    public function __construct($destination, $how = Request::METHOD_GET)
    {

    }

    /**
     * Make a new destination instance.
     */
    public static function make()
    {
        return resolve(static::class);
    }

    public function toArray()
    {
        return [
            'href' => $this->resolveDestination(),
            'method' => $this->how(),
        ];
    }

    // to

    // how

    // hasDestination
}