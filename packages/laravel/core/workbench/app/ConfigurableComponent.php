<?php

namespace Workbench\App;

use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\IsAnonymous;
use Honed\Core\Concerns\RequiresKey;
use Honed\Core\Primitive;

class ConfigurableComponent extends Primitive
{
    use HasType;
    use IsAnonymous;
    use RequiresKey;

    protected $anonymous = Primitive::class;

    const SETUP = 'configurable';

    public $key = 'component';

    public function setUp()
    {
        $this->setType(self::SETUP);
    }

    public static function make(): static
    {
        return resolve(static::class);
    }

    public function toArray()
    {
        return [
            'key' => $this->getKey(),
            'type' => $this->getType(),
        ];
    }
}
