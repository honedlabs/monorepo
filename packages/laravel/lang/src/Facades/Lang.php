<?php

declare(strict_types=1);

namespace Honed\Lang\Facades;

use BackedEnum;
use Honed\Lang\LangManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array<string, mixed> getTranslations() Get the available translations.
 * @method static static use(string|array<int, string> ...$files) Set the lang files to use.
 * @method static array<string, mixed> load(string $file) Load the translations for the given file.
 * @method static static only(string|array<int, string> ...$keys) Set the keys to use for the translations as dot notation.
 * @method static static using(string $file, string|array<int, string> $keys = []) Set the lang file to use and the keys to use for the translations as dot notation.
 * @method static string getLangPath() Get the path of the base directory where the language files are stored.
 * @method static string getLocale() Get the current locale.
 * @method static array<int, string|BackedEnum> availableLocales() Get the supported locales for the application.
 * @method static bool locale(string|BackedEnum|null $locale) Set the current locale.
 * @method static bool usesSession() Check if the session is used.
 * @method static string registerParameter() Register the locale as a default parameter in the URL generator.
 *
 * @see LangManager
 */
class Lang extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return LangManager
     */
    public static function getFacadeRoot()
    {
        // @phpstan-ignore-next-line
        return parent::getFacadeRoot();
    }

    /**
     * Get the registered name of the component.
     *
     * @return class-string<LangManager>
     */
    protected static function getFacadeAccessor()
    {
        return LangManager::class;
    }
}
