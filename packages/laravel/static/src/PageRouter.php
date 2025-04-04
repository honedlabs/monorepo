<?php

declare(strict_types=1);

namespace Honed\Pages;

use SplFileInfo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class PageRouter
{
    /**
     * Exclude files or folders from being registered as static pages.
     * 
     * @var array<int, string>
     */
    protected $except = [];

    /**
     * Only include the given files or folders that match the given pattern.
     * 
     * @var array<int, string>
     */
    protected $only = [];

    /**
     * Register the given directory as a static under the given URI.
     * 
     * @param string $directory
     * @param string|null $uri
     * @param string|false $name
     * @param bool $subdirectories
     * @return $this
     */
    public function create(
        $directory,
        $uri = null,
        $name = 'pages',
        $subdirectories = true
    ) {
        if (! $directory || ! File::isDirectory($directory)) {
            static::throwInvalidDirectory($directory);
        }

        $pages = $this->getPages($directory, $subdirectories);

        dd($pages);
    }

    /**
     * Exclude the given files or folders from being registered as static pages.
     * 
     * @param string|iterable<int,string> ...$patterns
     * @return $this
     */
    public function except(...$patterns)
    {
        $patterns = Arr::flatten($patterns);

        $this->except = \array_merge($this->except, $patterns);

        return $this;
    }

    /**
     * Get the files or folders that are excluded from being registered as 
     * static pages.
     * 
     * @return array<int, string>
     */
    public function getExcept()
    {
        return $this->except;
    }

    /**
     * Only include the given files or folders that match the given pattern.
     * 
     * @param string|iterable<int,string> ...$patterns
     * @return $this
     */
    public function only(...$patterns)
    {
        $patterns = Arr::flatten($patterns);

        $this->only = \array_merge($this->only, $patterns);

        return $this;
    }

    /**
     * Get the files or folders that are included to be registered as static 
     * pages.
     * 
     * @return array<int, string>
     */
    public function getOnly()
    {
        return $this->only;
    }

    /**
     * Get all valid pages from the immediate given directory.
     * 
     * @param string $directory
     * @param bool $subdirectories
     * @return array<int, string>
     */
    protected function getPages($directory)
    {
        return \array_reduce(
            File::allFiles($directory),
            function ($pages, SplFileInfo $file) {
                if ($this->isPage($file)) {
                    $pages[] = new Page($file->getRelativePathname());
                }

                return $pages;
            },
        );

        // Route::get('/', $callback)->name('pages.fss.index');
    }

    /**
     * Determine if the given file is a valid page.
     * 
     * @param \Symfony\Component\Finder\SplFileInfo $file
     * @return bool
     */
    protected function isPage($file)
    {
        $extensions = config('inertia.testing.page_extensions');

        $isValidExtension = filled($extensions)
            ? \in_array($file->getExtension(), $extensions)
            : true;

        return $file->isFile() && 
            $isValidExtension && 
            !\str_starts_with($file->getFilename(), '_');
    }

    public static function throwInvalidDirectory($directory)
    {
        throw new \Error('The directory [$directory] is not valid.');
    }
}