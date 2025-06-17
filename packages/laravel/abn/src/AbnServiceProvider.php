<?php

declare(strict_types=1);

namespace Honed\Abn;

use Honed\Abn\Rules\Abn;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;
use Illuminate\Validation\InvokableValidationRule;
use Illuminate\Validation\Rule;

class AbnServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Rule::macro('abn', function () {
            return new Abn();
        });

        $this->callAfterResolving('validator', function (Factory $validator) {
            $validator->extendDependent('abn', function ($attribute, $value, array $parameters, $validator) {
                $rule = new Abn();

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
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'abn');

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/abn'),
        ]);
    }
}
