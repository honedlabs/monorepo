<?php

declare(strict_types=1);

namespace Workbench\App\Policies;

use Workbench\App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $authed): bool
    {
        return $authed->id % 2 === 0;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $authed): bool
    {
        return $authed->id % 2 !== 0;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $authed): bool
    {
        return $authed->id % 2 === 0;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $authed): bool
    {
        return $authed->id % 2 !== 0;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    protected function forceDelete(User $user, User $authed): bool
    {
        return $authed->id % 2 === 0;
    }
}
