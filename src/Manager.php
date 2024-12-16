<?php

declare(strict_types=1);

namespace Honed\Crumb;

use Illuminate\Routing\Router;
use Honed\Crumb\Exceptions\CrumbsNotFoundException;
use Honed\Crumb\Exceptions\DuplicateCrumbsException;

class Manager
{
    /**
     * Trails paired to a key.
     * 
     * @var array<string,\Honed\Crumb\Trail>
     */
    protected $trails = [];

    /**
     * Crumbs to be added before the trail.
     * Useful for adding a home crumb to all trails.
     * 
     * @var array<string,\Honed\Crumb\Crumb>
     */
    protected $all = [];

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
        // dd($this->trails[$name]);
        if (!$this->exists($name)) {
            throw new CrumbsNotFoundException($name);
        }

        return ($this->trails[$name]);
        // return ($this->trails[$name])->usingRoute();
    }

}
