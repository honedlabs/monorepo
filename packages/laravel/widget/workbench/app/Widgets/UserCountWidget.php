<?php

declare(strict_types=1);

namespace App\Widgets;

use Honed\Widget\Widget;
use App\Models\User;

class UserCountWidget extends Widget
{
    protected $name = 'count';

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return User::query()->getquery()->count();
    }
}
