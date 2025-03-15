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
use Honed\Core\Primitive;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @extends Primitive<string,mixed>
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
     * Resolve the action's closures to an array.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return array<string,mixed>
     */
    public function resolveToArray($parameters = [], $typed = [])
    {
        return [
            'name' => $this->getName(),
            'label' => $this->resolveLabel($parameters, $typed),
            'type' => $this->getType(),
            'icon' => $this->resolveIcon($parameters, $typed),
            'extra' => $this->resolveExtra($parameters, $typed),
            'action' => $this->hasAction(),
            'confirm' => $this->getConfirm()?->resolveToArray($parameters, $typed),
            'route' => $this->routeToArray($parameters, $typed),
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
