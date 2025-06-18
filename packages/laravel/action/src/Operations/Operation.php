<?php

declare(strict_types=1);

namespace Honed\Action\Operations;

use Closure;
use Honed\Action\Concerns\HasAction;
use Honed\Action\Concerns\HasConfirm;
use Honed\Action\Confirm;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasExtra;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasRoute;
use Honed\Core\Concerns\HasType;
use Honed\Core\Primitive;
use Illuminate\Database\Eloquent\Model;

abstract class Operation extends Primitive
{
    use Allowable;
    use Concerns\HasAction;
    use HasConfirm;
    use HasExtra;
    use HasIcon;
    use HasLabel;
    use HasName;
    use HasRoute;
    use HasType;

    public const INLINE = 'inline';

    public const BULK = 'bulk';

    public const PAGE = 'page';

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->definition($this);
    }

    /**
     * Execute the action on a resource.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $record
     * @return mixed
     */
    abstract public function execute($record);

    /**
     * Create a new action instance.
     *
     * @param  string  $name
     * @param  string|Closure(mixed...):string|null  $label
     * @return static
     */
    public static function make($name, $label = null)
    {
        return resolve(static::class)
            ->name($name)
            ->label($label ?? static::makeLabel($name));
    }

    /**
     * Determine if the action is an inline action.
     *
     * @return bool
     */
    public function isInline()
    {
        return $this instanceof InlineOperation;
    }

    /**
     * Determine if the action is a bulk action.
     *
     * @return bool
     */
    public function isBulk()
    {
        return $this instanceof BulkOperation;
    }

    /**
     * Determine if the action is a page action.
     *
     * @return bool
     */
    public function isPage()
    {
        return $this instanceof PageOperation;
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
            'actionable' => $this->isAction(),
            'confirm' => $this->getConfirm()?->toArray(),
            'route' => $this->routeToArray(),
        ];
    }

    /**
     * Provide a selection of default dependencies for evaluation by name.
     * 
     * @param  string  $parameterName
     * @return array<int, mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        if (isset($this->parameters[$parameterName])) {
            return [$this->parameters[$parameterName]];
        }

        return match ($parameterName) {
            'confirm' => [$this->confirmInstance()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * Provide a selection of default dependencies for evaluation by type.
     * 
     * @param  string  $parameterType
     * @return array<int, mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        return match ($parameterType) {
            Confirm::class => [$this->confirmInstance()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }
}
