<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Workbench\App\Models\User;
use Workbench\App\Policies\UserPolicy;

use function Orchestra\Testbench\workbench_path;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        View::addLocation(workbench_path('resources/views'));

        Config::set([
            'inertia.testing' => [
                'ensure_pages_exist' => false,
                'page_paths' => [realpath(__DIR__)],
            ],
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Model::unguard();

        Gate::policy(User::class, UserPolicy::class);

        Gate::define('view', static fn (User $user) => $user->id === 1);
        Gate::define('edit', static fn (User $user) => $user->id === 2);
    }
}
