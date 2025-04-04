<?php

declare(strict_types=1);

namespace Honed\Pages;

use SplFileInfo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Request;

class PageRouter
{
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
     * @param string $path
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
     * @return string
     */
    public function getPath()
    {
        return $this->path ?? resource_path('js/Pages');
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
     * Register the given directory as a static under the given URI.
     * 
     * @param string|null $directory
     * @param string $uri
     * @param string|false $name
     * @param bool $subdirectories
     * @return $this
     */
    public function create(
        $directory = null,
        $uri = '/',
        $name = 'pages',
        $subdirectories = true
    ) {
        $directory = \rtrim($this->getPath(), '/').'/'.\trim($directory ?? '', '/');

        if (! $directory || ! File::isDirectory($directory)) {
            static::throwInvalidDirectory($directory);
        }

        $pages = $this->getPages($directory, $subdirectories);

        foreach ($pages as $page) {
            $this->registerPage($page, $uri, $name);
        }
    }

    /**
     * Get all valid pages from the immediate given directory.
     * 
     * @param string $directory
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
            ! \str_starts_with($file->getFilename(), '_');
    }

    /**
     * Register the given page as a route.
     * 
     * @param \Honed\Pages\Page $page
     * @param string $uri
     * @param string|false $name
     * @return void
     */
    protected function registerPage($page, $uri, $name)
    {
        $pageUri = \trim($uri, '/').'/'.\trim($page->getUri(), '/');

        // $pageName = $page->getName();

        // $name = $name ? \trim($name,'.').'.'.\trim($page->getName(), '.') : null;

        $route = Route::match(
            [Request::METHOD_GET, Request::METHOD_HEAD],
            $this->isDefault($page) ? Str::before($pageUri, '/') : $pageUri,
            $this->getClosure($page)
        );
    }

    /**
     * Determine if the given page is the default page.
     * 
     * @param \Honed\Pages\Page $page
     * @return bool
     */
    protected function isDefault($page)
    {
        return \mb_strtolower($page->getName()) === 'index';
    }

    /**
     * Get the closure for the given page.
     * 
     * @param \Honed\Pages\Page $page
     * @return \Closure(mixed...):\Inertia\ResponseFactory|\Inertia\Response
     */
    protected function getClosure($page)
    {
        $path = \rtrim($this->getPath(), '/').'/'.$page->getPath();

        return fn () => inertia($path);
    }

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