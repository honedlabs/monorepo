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
     * The path of the page.
     * 
     * @var string
     */
    protected $path;

    /**
     * Whether the page has substitute bindings.
     * 
     * @var bool
     */
    protected $binding = false;

    public function __construct($filename)
    {
        $this->path = \implode('/', \array_map(
            fn ($segment) => Str::kebab($segment),
            \explode('/', \pathinfo($filename, PATHINFO_DIRNAME))
        ));

        $filename = \pathinfo($filename, PATHINFO_FILENAME);

        if (\str_starts_with($filename, '[')) {
            $this->binding = true;
            $this->name = Str::camel(\trim($filename, '[]'));
        } else {
            $this->name = Str::kebab($filename);
        }
    }

    /**
     * Get the name of the page.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the directory of the path of the page.
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Determine if the page substitutes bindings.
     * 
     * @return bool
     */
    public function isBinding()
    {
        return $this->binding;
    }
}

