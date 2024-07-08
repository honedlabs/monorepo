<?php

namespace Workbench\App;

use Conquest\Core\Concerns\CanAuthorize;
use Conquest\Core\Concerns\CanTransform;
use Conquest\Core\Concerns\CanValidate;
use Conquest\Core\Concerns\HasDescription;
use Conquest\Core\Concerns\HasFormat;
use Conquest\Core\Concerns\HasHttpMethod;
use Conquest\Core\Concerns\HasLabel;
use Conquest\Core\Concerns\HasMetadata;
use Conquest\Core\Concerns\HasName;
use Conquest\Core\Concerns\HasProperty;
use Conquest\Core\Concerns\HasRoute;
use Conquest\Core\Concerns\HasType;
use Conquest\Core\Concerns\HasValue;
use Conquest\Core\Concerns\IsActive;
use Conquest\Core\Concerns\IsDefault;
use Conquest\Core\Concerns\IsKey;
use Conquest\Core\Concerns\RequiresKey;
use Conquest\Core\Primitive;

class Component extends Primitive
{
    use CanAuthorize;
    use CanTransform;
    use CanValidate;
    use HasDescription;
    use HasFormat;
    use HasHttpMethod;
    use HasLabel;
    use HasMetadata;
    use HasName;
    use HasProperty;
    use HasRoute;
    use HasType;
    use HasValue;
    use IsActive;
    use IsDefault;
    use IsKey;
    use RequiresKey;

    protected string $key = 'component';

    public function toArray()
    {
        return [
            
        ];
    }

}