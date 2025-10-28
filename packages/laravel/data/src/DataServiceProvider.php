<?php

declare(strict_types=1);

namespace Honed\Data;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/data.php', 'honed-data');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void 
    {
        $this->loadTranslationsFrom(
            __DIR__ . '/../resources/lang',
            'data'
        );

        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }
            

        if ($this->extendsValidator()) {
            $this->extendValidator();
        }
    }

    /**
     * Set whether the validator should be extended.
     */
    public static function shouldExtendValidator(bool $value = true): void
    {
        config()->set('data.extends_validator', $value);
    }

    /**
     * Determine if the validator should be extended.
     */
    public function extendsValidator(): bool
    {
        /** @var \Illuminate\Contracts\Config\Repository $config */
        $config = $this->app['config'];

        return (bool) $config->get('data.extends_validator', false);
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__ . '/../config/data.php' => config_path('data.php'),
        ], 'honed-data-config');
    }

    /**
     * Extend the validator with the custom rules.
     */
    protected function extendValidator(): void
    {
        /** @var \Illuminate\Contracts\Validation\Factory $validator */
        $validator = $this->app['validator'];

        /** @var \Illuminate\Contracts\Translation\Translator $translator */
        $translator = $this->app['translator'];

        foreach ($this->getRules() as $rule) {
            $ruleName = Str::snake(class_basename($rule));

            $validator->extend(
                $ruleName,
                function ($attribute, $value, $parameters, $validator) use ($rule) {
                    return (new $rule($parameters))->isValid($value);
                },
                $translator->get('data::validation.rules.'.$ruleName)
            );
        }
    }

    /**
     * Get the names of the rules classes.
     * 
     * @return list<class-string<AbstractRule>>
     */
    protected function getRules(): array
    {
    }
}
