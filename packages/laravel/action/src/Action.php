<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasType;
use Honed\Core\Contracts\ResolvesClosures;
use Honed\Core\Primitive;

/**
 * @extends \Honed\Core\Primitive<string,mixed>
 */
abstract class Action extends Primitive implements ResolvesClosures
{
    use Allowable;
    use HasIcon;
    use HasLabel;
    use HasName;
    use HasType;

    public function __construct(?string $name = null, string|\Closure|null $label = null)
    {
        parent::__construct();

        $this->name($name);
        $this->label($label ?? $this->makeLabel($name));
    }

    /**
     * Make a new action.
     */
    public static function make(?string $name = null, string|\Closure|null $label = null): static
    {
        return resolve(static::class, \compact('name', 'label'));
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
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model|null  $parameters
     * @param  array<string,mixed>|null  $typed
     * 
     * @return $this
     */
    public function resolve($parameters = null, $typed = null): static
    {
        $this->getLabel($parameters, $typed);
        $this->getName($parameters, $typed);
        $this->getIcon($parameters, $typed);
        // $this->getExtra($parameters, $typed);

        return $this;
    }
}
