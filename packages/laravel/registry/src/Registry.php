<?php

declare(strict_types=1);

namespace Honed\Registry;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Registry implements Jsonable
{
    /**
     * The name of the registry.
     * 
     * @var string|null
     */
    protected $name;

    /**
     * The homepage of the registry.
     * 
     * @var string|null
     */
    protected $homepage;

    /**
     * The author of the registry.
     * 
     * @var string|null
     */
    protected $author;

    /**
     * The items of the registry.
     * 
     * @var array<int, \Honed\Registry\RegistryItem>
     */
    protected $items;

    /**
     * Set the name of the registry.
     * 
     * @return string|null
     */
    public function name()
    {
        return null;
    }

    /**
     * Get the default name of the registry from the config.
     * 
     * @return string
     */
    public function defaultName()
    {
        /** @var string */
        return config('registry.name');
    }

    /**
     * Get the default path of the registry json file from the config.
     * 
     * @return string
     */
    public function defaultPath()
    {
        /** @var string */
        return Str::finish(config('registry.registry_path'), '.json');
    }

    /**
     * Get the name of the registry.
     * 
     * @return string
     */
    public function getName()
    {
        $name = $this->name ??= $this->name();

        return $name ?? $this->defaultName();
    }

    /**
     * Set the homepage of the registry.
     * 
     * @return string|null
     */
    public function homepage()
    {
        return null;
    }

    /**
     * Get the default homepage of the registry from the config.
     * 
     * @return string
     */
    public function defaultHomepage()
    {
        /** @var string */
        return config('registry.homepage');
    }

    /**
     * Get the homepage of the registry.
     * 
     * @return string
     */
    public function getHomepage()
    {
        $homepage = $this->homepage ??= $this->homepage();

        return $homepage ?? $this->defaultHomepage();
    }

    /**
     * Set the author of the registry.
     * 
     * @return string|null
     */
    public function author()
    {
        return null;
    }

    /**
     * Get the default author of the registry from the config.
     * 
     * @return string|null
     */
    public function defaultAuthor()
    {
        /** @var string */
        return config('registry.author');
    }

    /**
     * Get the author of the registry.
     * 
     * @return string|null
     */
    public function getAuthor()
    {
        $author = $this->author ??= $this->author();

        return $author ?? $this->defaultAuthor();
    }
    
    /**
     * {@inheritdoc}
     */
    public function toJson($options = 0)
    {
        return json_encode([
            'Hello' => 'World',
        ], $options);
    }

    /**
     * Serve the registry as a route.
     * 
     * @param string|null $path
     * @return \Illuminate\Routing\Route
     */
    public static function serve($path = null)
    {
        $registry = App::make(static::class);
        
        $path ??= $registry->defaultPath();

        return Route::get($path, function () use ($registry) {
            return response()->json($registry);
        });
    }

    // public function toArray()
    
    
}