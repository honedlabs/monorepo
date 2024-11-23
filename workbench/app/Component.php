<?php

declare(strict_types=1);

namespace Workbench\App;

use Honed\Core\Primitive;
use Honed\Core\Concerns\IsKey;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasTitle;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\IsActive;
use Honed\Core\Concerns\IsHidden;
use Honed\Core\Concerns\IsStrict;
use Honed\Core\Concerns\Encodable;
use Honed\Core\Concerns\HasFormat;
use Honed\Core\Concerns\IsDefault;
use Honed\Core\Concerns\IsVisible;
use Honed\Core\Concerns\IsAnonymous;
use Honed\Core\Concerns\Validatable;
use Honed\Core\Concerns\Authorizable;
use Honed\Core\Concerns\HasAttribute;
use Honed\Core\Concerns\Transformable;
use Honed\Core\Concerns\HasDescription;
use Honed\Core\Concerns\HasPlaceholder;
use Honed\Core\Identifier\Concerns\HasId;
use Honed\Core\Options\Concerns\HasOptions;

class Component extends Primitive
{
    use IsKey;
    use HasId;
    use HasMeta;
    use HasName;
    use HasType;
    use HasLabel;
    use HasTitle;
    use HasValue;
    use IsActive;
    use IsHidden;
    use IsStrict;
    use Encodable;
    use HasFormat;
    use IsDefault;
    use IsVisible;
    use HasOptions;
    use IsAnonymous;
    use Validatable;
    use Authorizable;
    use HasAttribute;
    use Transformable;
    use HasDescription;
    use HasPlaceholder;

    protected $anonymous = Component::class;

    public static function make(array $attributes = []): static
    {
        return new static($attributes);
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'value' => $this->getValue(),
            'label' => $this->getLabel(),
            'meta' => $this->getMeta(),
        ];
    }
}
