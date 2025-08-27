<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('even', function (User $user) {
            if ($user->getKey() % 2 === 0) {
                return true;
            }

            Response::denyAsNotFound();
        });

        Gate::define('odd', function (User $user) {
            return $user->getKey() % 2 === 1;
        });
    }
}
