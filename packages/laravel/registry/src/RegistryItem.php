<?php

namespace Honed\Registry;

use Honed\Registry\Concerns\HasRegistryType;

class RegistryItem
{
    use HasRegistryType;

    /**
     * The name of the item. This is used to identify the item in the registry. It should be unique for your registry.
     * 
     * @var string
     */
    protected $name;

    /**
     * The human-readable title for your registry item. Keep it short and descriptive.
     * 
     * @var string
     */
    protected $title;

    /**
     * The description of the item. This is used to provide a brief overview of the item.
     * 
     * @var string|null
     */
    protected $description;

    /**
     * The author of the item. Recommended format: username <url>
     * 
     * @var string|null
     */
    protected $author;

    /**
     * An array of NPM dependencies required by the registry item.
     * 
     * @var array<int, string>
     */
    protected $dependencies = [];

    /**
     * An array of NPM dev dependencies required by the registry item.
     * 
     * @var array<int, string>
     */
    protected $devDependencies = [];

    /**
     * An array of registry items that this item depends on. Use the name of the item to reference shadcn/ui components and urls to reference other registries.
     * 
     * @var array<int, string>
     */
    protected $registryDependencies = [];



    /**
     * 
     */

    // name (of the json file)
    // title
    // description

    // dependencies
    // registryDependencies
    // files

    // categories

    public function 
}
