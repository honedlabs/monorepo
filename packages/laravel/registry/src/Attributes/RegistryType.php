<?php

declare(strict_types=1);

namespace Honed\Registry\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class RegistryType
{
    /**
     * The type of the registry item.
     * 
     * @var string|\Honed\Registry\Enums\RegistryType
     */
    protected $type;

    /**
     * Create a new registry type attribute.
     * 
     * @param string|\Honed\Registry\Enums\RegistryType $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Get the type of the registry item.
     * 
     * @return string
     */
    public function getType()
    {
        if ($this->type instanceof RegistryType) {
            return $this->type->value;
        }

        return $this->type;
    }
}
