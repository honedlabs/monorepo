<?php

declare(strict_types=1);

namespace Honed\Lang\Facades;

use Honed\Lang\LangManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array<string, mixed> getTranslations() Get the available translations.
 * @method static static use(string ...$files) Set the lang files to use.
 * @method static array<string, mixed> load(string $file) Load the translations for the given file.
 * @method static static only(string ...$keys) Set the keys to use for the translations as dot notation.
 * @method static string getLangPath() Get the path of the base directory where the language files are stored.
 * @method static string getLocale() Get the current locale.
 * @method static array<int, string> availableLocales() Get the supported locales for the application.
 * @method static bool locale(string $locale) Set the current locale.
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
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lang';
    }
}
