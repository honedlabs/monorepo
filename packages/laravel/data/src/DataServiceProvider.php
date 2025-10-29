<?php

declare(strict_types=1);

namespace Honed\Data;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use SplFileInfo;

class DataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/honed-data.php', 'honed-data');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void 
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'honed-data');

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
        config()->set('honed-data.extends_validator', $value);
    }

    /**
     * Determine if the validator should be extended.
     */
    public function extendsValidator(): bool
    {
        /** @var \Illuminate\Contracts\Config\Repository $config */
        $config = $this->app['config']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible

        return (bool) $config->get('honed-data.extends_validator', false);
    }

    /**
     * Get the names of the rules classes.
     * 
     * @return list<class-string<AbstractRule>>
     */
    public function getRules(): array
    {
        /** @var list<string> */
        return array_map(
            static fn (SplFileInfo $file) => dd($file->getFilenameWithoutExtension()), 
            File::files(__DIR__.'/Rules')
        );
    }

    /**
     * Get the languages for the package.
     *
     * @return list<string>
     */
    public function getLanguages(): array
    {
        /** @var list<string> */
        return array_map(
            static fn (string $dir) => Str::afterLast($dir, '/'), 
            File::directories(__DIR__.'/../resources/lang')
        );
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__ . '/../config/honed-data.php' => config_path('honed-data.php'),
        ], 'honed-data-config');

        $this->publishes([
            __DIR__.'/../resources/lang' => lang_path('vendor/data'),
        ], 'honed-data-lang');

        foreach ($this->getLanguages() as $language) {
            $this->publishes([
                __DIR__.'/../resources/lang/'.$language => lang_path('vendor/data/'.$language),
            ], 'honed-data-lang-'.$language);
        }
    }

    /**
     * Extend the validator with the custom rules.
     */
    protected function extendValidator(): void
    {
        /** @var \Illuminate\Contracts\Validation\Factory $validator */
        $validator = $this->app['validator']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible

        /** @var \Illuminate\Contracts\Translation\Translator $translator */
        $translator = $this->app['translator']; // @phpstan-ignore-line offsetAccess.nonOffsetAccessible

        foreach ($this->getRules() as $rule) {
            $ruleName = Str::snake(class_basename($rule));

            $validator->extend(
                $ruleName,
                function ($attribute, $value, $parameters, $validator) use ($rule) {
                    return (new $rule($parameters))->isValid($value);
                },
                $translator->get('honed-data::validation.'.$ruleName)
            );
        }
    }
}
