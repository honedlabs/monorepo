<?php

namespace Workbench\App;

use Conquest\Core\Concerns\HasDescription;
use Conquest\Core\Concerns\HasFormat;
use Conquest\Core\Concerns\HasLabel;
use Conquest\Core\Concerns\HasMeta;
use Conquest\Core\Concerns\HasName;
use Conquest\Core\Concerns\HasPlaceholder;
use Conquest\Core\Concerns\HasProperty;
use Conquest\Core\Concerns\HasTitle;
use Conquest\Core\Concerns\HasType;
use Conquest\Core\Concerns\HasValue;
use Conquest\Core\Concerns\IsActive;
use Conquest\Core\Concerns\IsAnonymous;
use Conquest\Core\Concerns\IsAuthorized;
use Conquest\Core\Concerns\IsDefault;
use Conquest\Core\Concerns\IsHidden;
use Conquest\Core\Concerns\IsKey;
use Conquest\Core\Concerns\IsStrict;
use Conquest\Core\Concerns\IsVisible;
use Conquest\Core\Concerns\Routable;
use Conquest\Core\Concerns\Transforms;
use Conquest\Core\Concerns\Validates;
use Conquest\Core\Identifier\Concerns\HasId;
use Conquest\Core\Options\Concerns\HasOptions;
use Conquest\Core\Primitive;

class Component extends Primitive
{
    use HasDescription;
    use HasFormat;
    use HasId;
    use HasLabel;
    use HasMeta;
    use HasName;
    use HasOptions;
    use HasPlaceholder;
    use HasProperty;
    use HasTitle;
    use HasType;
    use HasValue;
    use IsActive;
    use IsAnonymous;
    use IsAuthorized;
    use IsDefault;
    use IsHidden;
    use IsKey;
    use IsStrict;
    use IsVisible;
    use Routable;
    use Transforms;
    use Validates;

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
