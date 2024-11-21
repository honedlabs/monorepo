<?php

namespace Workbench\App;

use Honed\Core\Concerns\HasDescription;
use Honed\Core\Concerns\HasFormat;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasPlaceholder;
use Honed\Core\Concerns\HasProperty;
use Honed\Core\Concerns\HasTitle;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\IsActive;
use Honed\Core\Concerns\IsAnonymous;
use Honed\Core\Concerns\IsAuthorized;
use Honed\Core\Concerns\IsDefault;
use Honed\Core\Concerns\IsHidden;
use Honed\Core\Concerns\IsKey;
use Honed\Core\Concerns\IsStrict;
use Honed\Core\Concerns\IsVisible;
use Honed\Core\Concerns\Routable;
use Honed\Core\Concerns\Transforms;
use Honed\Core\Concerns\Validates;
use Honed\Core\Identifier\Concerns\HasId;
use Honed\Core\Options\Concerns\HasOptions;
use Honed\Core\Primitive;

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
