<?php

declare(strict_types=1);

namespace Workbench\App\Classes;

use Honed\Core\Concerns\CanDeferLoading;
use Honed\Core\Concerns\CanQuery;
use Honed\Core\Concerns\HasLifecycleEvents;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasPipeline;
use Honed\Core\Concerns\HasType;
use Honed\Core\Contracts\HooksIntoLifecycle;
use Honed\Core\Pipes\CallsAfter;
use Honed\Core\Pipes\CallsBefore;
use Honed\Core\Primitive;
use Workbench\App\Models\User;
use Workbench\App\Pipes\SetName;

class Component extends Primitive implements HooksIntoLifecycle
{
    use CanDeferLoading;
    use CanQuery;
    use HasLifecycleEvents;
    use HasMeta;
    use HasName;
    use HasPipeline;
    use HasType;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'component';

    /**
     * Make a new instance of the component.
     *
     * @return static
     */
    public static function make()
    {
        return resolve(static::class);
    }

    /**
     * Get the representation of the instance.
     *
     * @return array<string,mixed>
     */
    protected function representation(): array
    {
        return [
            'type' => $this->getType(),
            'name' => $this->getName(),
            'meta' => $this->getMeta(),
        ];
    }

    /**
     * Define the instance.
     *
     * @param  $this  $component
     * @return $this
     */
    protected function definition(self $component): self
    {
        return $component
            ->type('component');
    }

    /**
     * Get the pipes to be used..
     *
     * @return array<int,class-string<\Honed\Core\Pipe<$this>>>
     */
    protected function pipes()
    {
        return [
            CallsBefore::class,
            SetName::class,
            CallsAfter::class,
        ];
    }

    /**
     * Provide a selection of default dependencies for evaluation by name.
     *
     * @param  string  $parameterName
     * @return array<int,mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        return match ($parameterName) {
            'user' => [User::query()->first()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * Provide a selection of default dependencies for evaluation by type.
     *
     * @param  string  $parameterType
     * @return array<int,mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        return match ($parameterType) {
            User::class => [User::query()->first()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }
}
