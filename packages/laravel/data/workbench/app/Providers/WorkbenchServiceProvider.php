<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('success', fn (?User $user) => true);
        Gate::define('fail', fn (?User $user) => false);

        config()->set('services.recaptcha.secret', 'test');
    }
}
