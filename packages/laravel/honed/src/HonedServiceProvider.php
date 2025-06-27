<?php

declare(strict_types=1);

namespace Honed\Honed;

use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Carbon\CarbonImmutable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HonedServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * 
     * @return void
     */
    public function register()
    {
        $this->registerMacros();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register the application's macros.
     * 
     * @return void
     */
    protected function registerMacros()
    {
        Blueprint::macro('authors', function (
            string $createdBy = 'created_by',
            string $updatedBy = 'updated_by',
            string $table = 'users',
        ) {
            /** @var \Illuminate\Database\Schema\Blueprint $this */

            $this->foreignId($createdBy)->nullable()->constrained($table);
            $this->foreignId($updatedBy)->nullable()->constrained($table);
        });
    }
}