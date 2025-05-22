<?php

declare(strict_types=1);

namespace Honed\Registry\Attributes;

use Attribute;
use Honed\Registry\Enums\RegistryType;

#[Attribute(Attribute::TARGET_CLASS)]
class Theme extends RegistryType
{
    /**
     * Create a new theme registry type attribute.
     */
    public function __construct()
    {
        parent::__construct(RegistryType::Theme);
    }
}