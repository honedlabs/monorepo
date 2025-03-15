<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasExtra;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasRoute;
use Honed\Core\Concerns\HasType;
use Honed\Core\Contracts\Resolves;
use Honed\Core\Primitive;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @extends \Honed\Core\Primitive<string,mixed>
 */
abstract class Action extends Primitive
{
    use Allowable;
    use Concerns\HasAction;
    use Concerns\HasConfirm;
    use ForwardsCalls;
    use HasExtra;
    use HasIcon;
    use HasLabel;
    use HasName;
    use HasRoute;
    use HasType;

    /**
     * Create a new action instance.
     *
     * @param  string  $name
     * @param  string|\Closure|null  $label
     * @return static
     */
    public static function make($name, $label = null)
    {
        return resolve(static::class)
            ->name($name)
            ->label($label ?? static::makeLabel($name));
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'type' => $this->getType(),
            'icon' => $this->getIcon(),
            'extra' => $this->getExtra(),
            'action' => $this->hasAction(),
            'confirm' => $this->getConfirm()?->toArray(),
            'route' => $this->routeToArray(),
        ];
    }

    /**
     * Get the array representation of the action's route if applicable.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return array<string,mixed>|null
     */
    public function routeToArray($parameters = [], $typed = [])
    {
        if (! $this->hasRoute()) {
            return null;
        }

        return [
            'href' => $this->resolveRoute($parameters, $typed),
            'method' => $this->getMethod(),
        ];
    }

    /**
     * Resolve the array using closure dependencies.
     *
     * @param  array<string,mixed>  $named
     * @param  array<class-string,mixed>  $typed
     * @return $this
     */
    public function resolveToArray($named = [], $typed = [])
    {
        return [
            'name' => $this->getName(),
            'label' => $this->resolveLabel($named, $typed),
            'type' => $this->getType(),
            'icon' => $this->resolveIcon($named, $typed),
            'extra' => $this->resolveExtra($named, $typed),
            'action' => $this->hasAction(),
            'confirm' => $this->getConfirm()?->resolveToArray($named, $typed),
            'route' => $this->routeToArray($named, $typed),
        ];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        return match ($parameterName) {
            'confirm' => [$this->confirmInstance()],
            default => [],
        };
    }

    /**
     * {@inheritdoc}
     */
    public function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        return match ($parameterType) {
            Confirm::class => [$this->confirmInstance()],
            default => [App::make($parameterType)],
        };
    }
}
