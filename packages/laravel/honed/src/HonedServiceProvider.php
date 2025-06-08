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
        $this->bootCommands();
        $this->bootDates();
        $this->bootModels();
        $this->bootUrl();
        $this->bootVite();
        $this->bootStrayRequests();
    }

    /**
     * Register the application's macros.
     * 
     * @return void
     */
    protected function registerMacros()
    {
        Blueprint::macro('authors', function (string $createdBy = 'created_by', string $updatedBy = 'updated_by') {
            /** @var \Illuminate\Database\Schema\Blueprint $this */

            $this->foreignId($createdBy)->nullable()->constrained('users');
            $this->foreignId($updatedBy)->nullable()->constrained('users');
        });
    }

    /**
     * Configure the application's dates.
     *
     * @see https://dyrynda.com.au/blog/laravel-immutable-dates
     * 
     * @return void
     */
    protected function bootDates()
    {
        Date::use(CarbonImmutable::class);
    }

    /**
     * Configure the application's commands.
     * 
     * @return void
     */
    protected function bootCommands()
    {
        DB::prohibitDestructiveCommands(App::isProduction());
    }

    /**
     * Configure the application's models.
     * This is optional, but it's recommended to enable strict mode and disable mass assignment.
     *
     * @see https://laravel.com/docs/eloquent#configuring-eloquent-strictness
     * 
     * @return void
     */
    protected function bootModels()
    {
        Model::shouldBeStrict();
        Model::unguard();
        Model::automaticallyEagerLoadRelationships();
    }

    /**
     * Configure the application's URL.
     * This is optional, but it's recommended to force HTTPS in production.
     *
     * @see https://laravel.com/docs/octane#serving-your-application-via-https
     * 
     * @return void
     */
    protected function bootUrl()
    {
        URL::forceHttps(App::isProduction());
    }

    /**
     * Configure the application's Vite loading strategy.
     * 
     * @return void
     */
    protected function bootVite()
    {
        Vite::useAggressivePrefetching();
    }

    /**
     * Throw an exception if any request is not faked.
     * 
     * @return void
     */
    protected function bootStrayRequests()
    {
        Http::preventStrayRequests();
    }
}