<?php

namespace Workbench\App;

use Conquest\Core\Concerns\HasType;
use Conquest\Core\Concerns\RequiresKey;
use Conquest\Core\Primitive;

class ConfigurableComponent extends Primitive
{
    use RequiresKey;
    use HasType;

    public const SETUP = 'configurable';
    public $key = 'component';
    
    public function setUp() 
    {
        $this->setType(self::SETUP);
    }

    public function make(): static
    {
        return resolve(static::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'value' => $this->getValue(),
            'label' => $this->getLabel(),
            'metadata' => $this->getMetadata(),            
        ];
    }
}