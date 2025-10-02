<?php

declare(strict_types=1);

namespace Honed\Lang;

use Illuminate\Support\Arr;

class Lang
{
    /**
     * The loaded translations.
     * 
     * @var array<string, mixed>
     */
    protected $translations = [];

    /**
     * The keys to use for the translations.
     * 
     * @var array<int, string>
     */
    protected $only = [];

    /**
     * Set the lang files to use.
     * 
     * @return $this
     */
    public function use(string ...$files): static
    {
        Arr::mapWithKeys($files, fn (string $file) => [$file => $this->load($file)]);

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

        $lang = app()->getLocale();
        $basePath = rtrim(config('lang-manager.lang_path', lang_path()), '/');
        $path = "{$basePath}/{$lang}/{$file}.php";

        $this->translations[$file] = file_exists($path) ? require $path : [];

        return $this->translations[$file];
    }
}