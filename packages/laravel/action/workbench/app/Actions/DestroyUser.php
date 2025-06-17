<?php

declare(strict_types=1);

namespace Workbench\App\Actions;

use Honed\Action\Contracts\Action;
use Workbench\App\Models\User;

class DestroyUser implements Action
{
    public function handle(User $user)
    {
        $user->delete();

        return back();
    }
}
