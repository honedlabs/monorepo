<?php

declare(strict_types=1);

namespace Workbench\App\Actions\Product;

use Honed\Action\Actions\AttachAction;

/**
 * @template TModel of \Workbench\App\Models\Product
 * @template TUser of \Workbench\App\Models\User
 *
 * @extends \Honed\Action\Actions\AttachAction<TModel, TUser>
 */
class AttachUser extends AttachAction
{
    /**
     * Get the relation name, must be a belongs to many relationship.
     */
    public function relationship(): string
    {
        return 'users';
    }
}
