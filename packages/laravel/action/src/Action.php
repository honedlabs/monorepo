<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Primitive;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\Authorizable;

abstract class Action extends Primitive
{
    use Authorizable;
    use HasLabel;
    use HasMeta;
    use HasName;
    use HasIcon;
    use HasType;

    /**
     * Construct the action.
     * 
     * @param string $name
     * @param string|\Closure $label
     */
    public function __construct($name, $label = null)
    {
        parent::__construct();

        $this->name($name);
        $this->label($label ?? $this->makeLabel($name));
    }

    /**
     * Make a new action.
     * 
     * @param string $name
     * @param string|\Closure $label
     * @return static
     */
    public static function make($name, $label = null)
    {
        return new static($name, $label);
    }

    /**
     * Create the action as an array.
     * 
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name(),
            'label' => $this->label(),
            'type' => $this->type(),
            'icon' => $this->icon(),
            'meta' => $this->meta(),
        ];
    }
}