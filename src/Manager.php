<?php

declare(strict_types=1);

namespace Honed\Crumb;

use Illuminate\Routing\Router;
use Honed\Crumb\Exceptions\CrumbsNotFoundException;
use Honed\Crumb\Exceptions\DuplicateCrumbsException;

class Manager
{
    /**
     * @var array<string,\Honed\Crumb\Trail>
     */
    protected $trails = [];

    /** 
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function for(string $name, \Closure $trail)
    {
        if ($this->exists($name)) {
            throw new DuplicateCrumbsException($name);
        }

        $this->trails[$name] = $trail;
    }

    /**
     * Determine if a crumb with the given name exists. 
     */
    public function exists(string $name): bool
    {
        return isset($this->trails[$name]);
    }

    public function get(string $name)
    {
        if (!$this->exists($name)) {
            throw new CrumbsNotFoundException($name);
        }

        return ($this->trails[$name]);
        // return ($this->trails[$name])->usingRoute();
    }

}
