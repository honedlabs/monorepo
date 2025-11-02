<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasAttributes;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;
use Honed\Form\Concerns\BelongsToForm;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Primitive<string, mixed>
 */
abstract class Component extends Primitive implements NullsAsUndefined
{
    use Allowable;
    use BelongsToForm;
    use HasAttributes;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'component';

    /**
     * The name of the component.
     *
     * @var ?string
     */
    protected $component;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->define();
    }

    /**
     * The name of the component.
     */
    abstract public function component(): string|BackedEnum;

    /**
     * Set the name of the component.
     *
     * @return $this
     */
    public function as(?string $value): static
    {
        $this->component = $value;

        return $this;
    }

    /**
     * Get the name of the component.
     */
    public function getComponent(): string
    {
        if (isset($this->component)) {
            return $this->component;
        }

        $component = $this->component();

        return is_string($component) ? $component : (string) $component->value;
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $this->form($this->getForm());

        return parent::toArray();
    }

    /**
     * Get the array representation of the component.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'component' => $this->getComponent(),
            'attributes' => $this->getAttributes() ?: null,
        ];
    }

    /**
     * Provide a selection of default dependencies for evaluation by name.
     *
     * @return list<mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return match ($parameterName) {
            'model', 'record', 'row' => [$this->getRecord()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * Provide a selection of default dependencies for evaluation by type.
     *
     * @param  class-string  $parameterType
     * @return list<mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    {
        $record = $this->getRecord();

        if (! $record instanceof Model) {
            return parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType);
        }

        return match ($parameterType) {
            Model::class, $record::class => [$record],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }
}
