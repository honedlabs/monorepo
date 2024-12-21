<?php

declare(strict_types=1);

namespace Honed\Lock;

use Honed\Core\Concerns\Evaluable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class Lock
{
    /**
     * The globally defined permissions for the application.
     * 
     * @var array<string,bool>
     */
    protected $permissions = [];

    /**
     * Permissions for a single resource to be appended to the permissions.
     * 
     * @var array<string,bool>
     */
    protected $abilities = [];

    /**
     * Whether models should include the abilities attribute when retrieving.
     * 
     * @var bool
     */
    protected $includeAbilities = false;

    public function __construct()
    {

    }

    /**
     * Set the gates to use to manage permissions for the application frontend.
     */
    public function permissions($permissions)
    {

    }

    public function forModel(Model $model)
    {
        Gate::getPolicyFor($model);
    }

    /**
     * Share the current set permissions with the frontend.
     */
    public function share(): static
    {
        Inertia::share('lock', [
            
        ]);

        return $this;
    }

    /**
     * Always include the abilities attribute when retrieving models.
     * 
     * @return void
     */
    public function shouldIncludeAbilities(): void
    {
        $this->includeAbilities = true;
    }

    /**
     * Determine if the abilities attribute should be included when retrieving models.
     * 
     * @internal
     * @return bool
     */
    public function includeAbilities(): bool
    {
        return $this->includeAbilities;
    }
}