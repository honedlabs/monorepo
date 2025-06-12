<?php

namespace Workbench\App\Actions\Product;

use Honed\Action\Presets\AttachAction;

class AttachUser extends AttachAction
{
    /**
     * Get the relation name, must be a belongs to many relationship.
     * 
     * @return string
     */
    protected function relationship()
    {
        return 'users';
    }
}