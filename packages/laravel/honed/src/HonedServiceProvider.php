<?php

declare(strict_types=1);

namespace Honed\Honed;

use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HonedServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureCommands();
        $this->configureDates();
        $this->configureModels();
        $this->configureUrl();
        $this->configureVite();
        $this->configureStrayRequests();
    }

    /**
     * Configure the application's dates.
     *
     * @see https://dyrynda.com.au/blog/laravel-immutable-dates
     * 
     * @return void
     */
    private function configureDates()
    {
        Date::use(CarbonImmutable::class);
    }

    /**
     * Configure the application's commands.
     * 
     * @return void
     */
    private function configureCommands()
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
    private function configureModels()
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
    private function configureUrl()
    {
        URL::forceHttps(App::isProduction());
    }

    /**
     * Configure the application's Vite loading strategy.
     * 
     * @return void
     */
    private function configureVite()
    {
        Vite::useAggressivePrefetching();
    }

    /**
     * Throw an exception if any request is not faked.
     * 
     * @return void
     */
    private function configureStrayRequests()
    {
        Http::preventStrayRequests();
    }
}