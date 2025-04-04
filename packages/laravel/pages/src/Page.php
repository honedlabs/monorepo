<?php

declare(strict_types=1);

namespace Honed\Pages;

use Illuminate\Support\Str;

class Page
{
    /**
     * The name of the page.
     *
     * @var string
     */
    protected $name;

    /**
     * The path to the page from the pages directory as configured by
     * createInertiaApp().
     *
     * @var string
     */
    protected $path;

    /**
     * The uri of the page to register.
     *
     * @var string
     */
    protected $uri;

    /**
     * Whether the page has substitute bindings.
     *
     * @var string|null
     */
    protected $binding = null;

    /**
     * Create a new page instance.
     *
     * @param  string  $filename
     */
    public function __construct($filename)
    {
        $directory = \pathinfo($filename, PATHINFO_DIRNAME);
        $name = \pathinfo($filename, PATHINFO_FILENAME);

        $this->name = $name;
        $this->path = ($directory === '.' ? '' : $directory.'/').$name;

        $uri = implode('/', array_map(
            fn ($segment) => Str::kebab($segment),
            explode('/', $directory)
        ));

        $processedName = str_starts_with($name, '[')
            ? '{'.($this->binding = Str::camel(trim($name, '[]'))).'}'
            : Str::kebab($name);

        $this->uri = trim("$uri/$processedName", '/.');
    }

    /**
     * Get the name of the page file.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the path to the file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the uri this page should be located at.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Determine if the page has route model binding.
     *
     * @return bool
     */
    public function hasBinding()
    {
        return isset($this->binding);
    }

    /**
     * Get the route model binding parameter.
     *
     * @return string|null
     */
    public function getBinding()
    {
        return $this->binding;
    }
}
