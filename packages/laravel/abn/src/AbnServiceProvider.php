<?php

declare(strict_types=1);

namespace Honed\Abn;

use Honed\Abn\Rules\AbnRule;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;
use Illuminate\Validation\InvokableValidationRule;
use Illuminate\Validation\Rule;

class AbnServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Rule::macro('abn', function () {
            return new AbnRule();
        });

        $this->callAfterResolving('validator', function (Factory $validator) {
            $validator->extendDependent('abn', function ($attribute, $value, array $parameters, $validator) {
                $rule = new AbnRule();

                $validator->setCustomMessages([
                    'abn' => $rule->message($attribute),
                ]);

                return InvokableValidationRule::make($rule)
                    ->setValidator($validator)
                    ->passes($attribute, $value);
            });
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'abn');

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }
    }

    /**
     * Register the publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/abn'),
        ]);
    }
}
