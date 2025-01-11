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

/**
 * @extends \Honed\Core\Primitive<string,mixed>
 */
abstract class Action extends Primitive
{
    use Allowable;
    use HasLabel;
    use HasMeta;
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
            'meta' => $this->getMeta(),
        ];
    }
}