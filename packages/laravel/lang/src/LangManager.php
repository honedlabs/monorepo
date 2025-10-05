<?php

declare(strict_types=1);

namespace Honed\Lang;

use BackedEnum;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;

class LangManager
{
    /**
     * The loaded translations.
     *
     * @var array<string, array<string, mixed>>
     */
    protected $translations = [];

    /**
     * The keys to use for the translations.
     *
     * @var array<int, string>
     */
    protected $only = [];

    public function __construct(
        protected Application $app
    ) {}

    /**
     * Get the available translations.
     *
     * @return array<string, mixed>
     */
    public function getTranslations(): array
    {
        if (empty($this->only)) {
            return $this->translations;
        }

        $translations = [];

        foreach ($this->only as $key) {
            $value = Arr::get($this->translations, $key);

            if (is_null($value)) {
                continue;
            }

            Arr::set($translations, $key, $value);
        }

        return $translations;
    }

    /**
     * Set the lang files to use.
     *
     * @param  string|array<int, string>  $files
     * @return $this
     */
    public function use(string|array $files): static
    {
        /** @var array<int, string> */
        $files = is_array($files) ? $files : func_get_args();

        Arr::mapWithKeys($files, fn (string $file) => [$file => $this->load($file)]);

        return $this;
    }

    /**
     * Set the keys to use for the translations as dot notation.
     *
     * @param  string|array<int, string>  $keys
     * @return $this
     */
    public function only(string|array $keys): static
    {
        /** @var array<int, string> */
        $keys = is_array($keys) ? $keys : func_get_args();

        $this->only = $keys;

        return $this;
    }

    /**
     * Set the keys to use for the translations as dot notation.
     *
     * @param  string|array<int, string>  $keys
     * @return $this
     */
    public function using(string $file, string|array $keys): static
    {
        return $this->use($file)->only($keys);
    }

    /**
     * Load the translations for the given file.
     *
     * @return array<string, mixed>
     */
    public function load(string $file): array
    {
        if (isset($this->translations[$file])) {
            return $this->translations[$file];
        }

        $path = "{$this->getLangPath()}/{$this->getLocale()}/{$file}.php";

        $this->translations[$file] = file_exists($path) ? require $path : [];

        return $this->translations[$file];
    }

    /**
     * Get the path of the base directory where the language files are stored.
     */
    public function getLangPath(): string
    {
        /** @var string */
        $base = config('lang.lang_path', lang_path());

        return rtrim($base, '/');
    }

    /**
     * Get the current locale.
     */
    public function getLocale(): string
    {
        return $this->app->getLocale();
    }

    /**
     * Get the supported locales for the application.
     *
     * @return array<int, string|BackedEnum>
     */
    public function availableLocales(): array
    {
        /** @var array<int, string|BackedEnum> */
        $locales = (array) config('lang.locales', []);

        return array_map(static::normalizeLocale(...), $locales);
    }

    /**
     * Set the current locale.
     */
    public function locale(string|BackedEnum $locale): bool
    {
        $locale = $this->normalizeLocale($locale);

        if (! in_array($locale, $this->availableLocales())) {
            return false;
        }

        $this->app->setLocale($locale);

        return true;
    }

    /**
     * Normalize the locale to a string.
     */
    protected static function normalizeLocale(string|BackedEnum $locale): string
    {
        /** @var string */
        return is_string($locale) ? $locale : $locale->value;
    }
}
