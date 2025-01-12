<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Primitive;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Contracts\ResolvesClosures;

/**
 * @extends \Honed\Core\Primitive<string,mixed>
 */
abstract class Action extends Primitive implements ResolvesClosures
{
    use Allowable;
    use HasLabel;
    use HasName;
    use HasIcon;
    use HasType;

    public function __construct(string $name, string|\Closure $label = null)
    {
        parent::__construct();

        $this->name($name);
        $this->label($label ?? $this->makeLabel($name));
    }

    /**
     * Make a new action.
     */
    public static function make(string $name, string|\Closure $label = null): static
    {
        return new static($name, $label);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'type' => $this->getType(),
            'icon' => $this->getIcon(),
            'extra' => null,
        ];
    }

    /**
     * @return $this
     */
    public function resolve($parameters = null, $typed = null): static
    {
        $this->getLabel($parameters, $typed);
        $this->getName($parameters, $typed);
        $this->getIcon($parameters, $typed);
        $this->getExtra($parameters, $typed);

        return $this;
        
    }
}