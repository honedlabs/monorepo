<?php

declare(strict_types=1);

namespace Honed\Core\Tests\Stubs;

use Honed\Core\Concerns\Authorizable;
use Honed\Core\Concerns\Encodable;
use Honed\Core\Concerns\HasAlias;
use Honed\Core\Concerns\HasAttribute;
use Honed\Core\Concerns\HasDescription;
use Honed\Core\Concerns\HasFormat;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasPlaceholder;
use Honed\Core\Concerns\HasScope;
use Honed\Core\Concerns\HasTitle;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\IsActive;
use Honed\Core\Concerns\IsAnonymous;
use Honed\Core\Concerns\IsDefault;
use Honed\Core\Concerns\IsHidden;
use Honed\Core\Concerns\IsKey;
use Honed\Core\Concerns\IsStrict;
use Honed\Core\Concerns\IsVisible;
use Honed\Core\Concerns\Transformable;
use Honed\Core\Concerns\Validatable;
use Honed\Core\Identifier\Concerns\HasId;
use Honed\Core\Options\Concerns\HasOptions;
use Honed\Core\Primitive;

class Component extends Primitive
{
    use Authorizable;
    use Encodable;
    use HasAlias;
    use HasAttribute;
    use HasDescription;
    use HasFormat;
    use HasId;
    use HasLabel;
    use HasMeta;
    use HasName;
    use HasOptions;
    use HasPlaceholder;
    use HasScope;
    use HasScope;
    use HasTitle;
    use HasType;
    use HasValue;
    use IsActive;
    use IsAnonymous;
    use IsDefault;
    use IsHidden;
    use IsKey;
    use IsStrict;
    use IsVisible;
    use Transformable;
    use Validatable;

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
