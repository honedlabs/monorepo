<?php

declare(strict_types=1);

namespace Honed\Lang;

use BackedEnum;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

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

        $this->only = [...$this->only, ...$keys];

        return $this;
    }

    /**
     * Set the keys to use for the translations as dot notation.
     *
     * @param  string|array<int, string>  $keys
     * @return $this
     */
    public function using(string $file, string|array $keys = []): static
    {
        $this->use($file);

        if (! empty($keys)) {
            $this->only(array_map(fn (string $key) => "{$file}.{$key}", (array) $keys));
        }

        return $this;
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

        if ($this->usesSession()) {
            $this->getSession()->put('_lang', $locale);
        }

        $this->app->setLocale($locale);

        return true;
    }

    /**
     * Get the current locale.
     */
    public function getLocale(): string
    {
        return $this->app->getLocale();
    }

    /**
     * Check if the session is used.
     */
    public function usesSession(): bool
    {
        return (bool) config('lang.session', true);
    }

    /**
     * Register the locale as a default parameter in the URL generator.
     */
    public function registerParameter(): string
    {
        $locale = $this->getLocale();

        $this->getUrlGenerator()->defaults(['locale' => $locale]);

        return $locale;
    }

    /**
     * Normalize the locale to a string.
     */
    protected static function normalizeLocale(string|BackedEnum $locale): string
    {
        /** @var string */
        return is_string($locale) ? $locale : $locale->value;
    }

    /**
     * Get the session manager from the app.
     */
    protected function getSession(): SessionManager
    {
        // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
        return $this->app['session'];
    }

    protected function getUrlGenerator(): UrlGenerator
    {
        // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible
        return $this->app['url'];
    }
}
