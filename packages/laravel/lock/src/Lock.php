<?php

declare(strict_types=1);

namespace Honed\Lock;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class Lock
{
    /**
     * The globally defined permissions for the application.
     * 
     * @var array<string,bool>
     */
    protected $permissions;

    /**
     * Permissions for a set model
     * 
     * @var array<string,bool>
     */
    protected $abilities;

    public function __construct()
    {

    }

    public function permissions($permissions)
    {
        
    }

    public function forModel(Model $model)
    {
        Gate::getPolicyFor($model);
    }
    
}