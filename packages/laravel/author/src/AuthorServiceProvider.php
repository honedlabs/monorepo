<?php

declare(strict_types=1);

namespace Honed\Author;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AuthorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/author.php', 'author');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->offerPublishing();
        $this->bootMacros();
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/author.php' => config_path('author.php'),
        ], 'author-config');
    }

        /**
     * Register the macros for the package.
     */
    public function bootMacros(): void
    {
        Blueprint::macro('authorable', function (string $table = 'users') {
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            $this->foreignId('created_by')->nullable()->constrained($table)->nullOnDelete();
            $this->foreignId('updated_by')->nullable()->constrained($table)->nullOnDelete();
        });

        Blueprint::macro('deleteable', function (string $table = 'users') {
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            $this->softDeletes();
            $this->foreignId('deleted_by')->nullable()->constrained($table)->nullOnDelete();
        });
    }
}
