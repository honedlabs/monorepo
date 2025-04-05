<?php

declare(strict_types=1);

namespace Honed\Page;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use SplFileInfo;
use Symfony\Component\HttpFoundation\Request;

class PageRouter
{
    const DEFAULT_PAGE_NAME = 'index'; // Case insensitive

    /**
     * The path where the pages are located.
     *
     * @var string|null
     */
    protected $path;

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
     * Set the path where your pages are located.
     *
     * @param  string  $path
     * @return $this
     */
    public function path($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the path where your pages are located.
     *
     * @default 'resources/js/Pages'
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path ?? resource_path('js/Pages');
    }

    /**
     * Clear the pages path.
     *
     * @return $this
     */
    public function flushPath()
    {
        $this->path = null;
    }

    /**
     * Exclude the given files or folders from being registered as static pages.
     *
     * @param  string|iterable<int,string>  ...$patterns
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
     * Clear the excluded files or folders.
     *
     * @return $this
     */
    public function flushExcept()
    {
        $this->except = [];

        return $this;
    }

    /**
     * Only include the given files or folders that match the given pattern.
     *
     * @param  string|iterable<int,string>  ...$patterns
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
     * Clear the included files or folders.
     *
     * @return $this
     */
    public function flushOnly()
    {
        $this->only = [];

        return $this;
    }

    /**
     * Register the given directory as a static under the given URI.
     *
     * @param  string|null  $directory
     * @param  string  $uri
     * @param  string|false  $name
     * @return void
     */
    public function create(
        $directory = null,
        $uri = '/',
        $name = 'pages',
    ) {
        $directory = \rtrim(\rtrim($this->getPath(), '/').'/'.\trim($directory ?? '', '/'), '/');

        if (! File::isDirectory($directory)) {
            static::throwInvalidDirectory($directory);
        }

        $pages = $this->getPages($directory);

        foreach ($pages as $page) {
            $this->registerPage($page, $uri, $name);
        }
    }

    /**
     * Get all valid pages from the immediate given directory.
     *
     * @param  string  $directory
     * @return array<int, \Honed\Page\Page>
     */
    protected function getPages($directory)
    {
        return \array_reduce(
            File::allFiles($directory),
            function (array $pages, SplFileInfo $file) {
                if ($this->isValidPage($file)) {
                    $pages[] = new Page($file->getRelativePathname());
                }

                return $pages;
            }, []
        );
    }

    /**
     * Determine if the given file is a valid page.
     *
     * @param  \Symfony\Component\Finder\SplFileInfo  $file
     * @return bool
     */
    protected function isValidPage($file)
    {
        /** @var array<int, string> */
        $extensions = config('inertia.testing.page_extensions', []);

        return match (true) {
            ! $file->isFile(),

            \str_starts_with($file->getFilename(), '_'),

            filled($extensions) && ! \in_array($file->getExtension(), $extensions),

            filled($this->getOnly()) && ! $this->matchesOnly($file),

            filled($this->getExcept()) && $this->matchesExcept($file) => false,

            default => true,
        };
    }

    /**
     * Determine if the given file matches any of the given only patterns.
     * 
     * @param  \Symfony\Component\Finder\SplFileInfo  $file
     * @return bool
     */
    protected function matchesOnly($file)
    {
        return (bool) Arr::first(
            $this->getOnly(), 
            fn ($pattern) => $this->isMatching($file, $pattern),
            false
        );
    }

    /**
     * Determine if the given file matches any of the given except patterns.
     * 
     * @param  \Symfony\Component\Finder\SplFileInfo  $file
     * @return bool
     */
    protected function matchesExcept($file)
    {
        return (bool) Arr::first(
            $this->getExcept(), 
            fn ($pattern) => $this->isMatching($file, $pattern),
            false
        );
    }

    /**
     * Check if the given file matches the given pattern.
     * 
     * @param  \Symfony\Component\Finder\SplFileInfo  $file
     * @param  string  $pattern
     * @return bool
     */
    protected function isMatching($file, $pattern)
    {
        return Str::is($pattern, $file->getFilename());
    }
    /**
     * Register the given page as a route.
     *
     * @param  \Honed\Pages\Page  $page
     * @param  string  $uri
     * @param  string|false  $name
     * @return void
     */
    protected function registerPage($page, $uri, $name)
    {
        $pageUri = \trim($uri, '/').'/'.\trim($page->getUri(), '/');

        // $pageName = $page->getName();

        // $name = $name ? \trim($name,'.').'.'.\trim($page->getName(), '.') : null;

        Route::match(
            [Request::METHOD_GET, Request::METHOD_HEAD],
            $this->isDefault($page) ? Str::beforeLast($pageUri, '/') : $pageUri,
            $this->getClosure($page)
        );
    }

    /**
     * Determine if the given page is the default page.
     *
     * @param  \Honed\Pages\Page  $page
     * @return bool
     */
    protected function isDefault($page)
    {
        return \mb_strtolower($page->getName()) === static::DEFAULT_PAGE_NAME;
    }

    /**
     * Get the closure for the given page.
     *
     * @param  \Honed\Pages\Page  $page
     * @return \Closure
     */
    protected function getClosure($page)
    {
        $path = \rtrim($this->getPath(), '/').'/'.$page->getPath();

        if ($page->hasBinding()) {
            return fn ($parameter) => inertia($path, [
                $page->getBinding() => $parameter,
            ]);
        }

        return fn () => inertia($path);
    }

    /**
     * Throw an error if the given directory is not valid.
     *
     * @param  string  $directory
     * @return never
     *
     * @throws \Error
     */
    public static function throwInvalidDirectory($directory)
    {
        throw new \Error(
            \sprintf(
                'The directory [%s] is not valid.',
                $directory
            )
        );
    }
}
