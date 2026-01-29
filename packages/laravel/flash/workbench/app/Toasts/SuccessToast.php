<?php

declare(strict_types=1);

namespace Workbench\App\Toasts;

use Honed\Flash\Toast;

class SuccessToast extends Toast
{
    /**
     * Define the toast.
     *
     * @return $this
     */
    protected function definition(): static
    {
        return $this
            ->message('This was a successful operation.')
            ->success()
            ->duration(5000);
    }
}
