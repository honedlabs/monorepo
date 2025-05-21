<?php

namespace Honed\Registry;

use Honed\Registry\Concerns\HasRegistryType;

class RegistryItem
{
    use HasRegistryType;

    /**
     * The unique name of the registry item.
     * 
     * @var string
     */
    protected $name;

    /**
     * The title of the registry item.
     * 
     * @var string
     */
    protected $title;

    /**
     * The description of the registry item.
     * 
     * @var string|null
     */
    protected $description;

    /**
     * The registry dependenies from external sources.
     * 
     * @var array<int, string>
     */
    protected $registryDependencies = [];

    /**
     * The internal, registry dependencies for other registry items.
     * 
     * @var array<int, string>
     */
    protected $dependencies = [];

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
