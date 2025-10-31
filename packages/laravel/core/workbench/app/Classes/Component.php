<?php

declare(strict_types=1);

namespace Workbench\App\Classes;

use Honed\Core\Concerns\Definable;
use Honed\Core\Concerns\Encodable;
use Honed\Core\Concerns\HasLifecycleHooks;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasPipeline;
use Honed\Core\Concerns\HasQuery;
use Honed\Core\Concerns\HasType;
use Honed\Core\Contracts\HooksIntoLifecycle;
use Honed\Core\Pipes\CallsAfter;
use Honed\Core\Pipes\CallsBefore;
use Honed\Core\Primitive;
use Workbench\App\Models\User;
use Workbench\App\Pipes\SetType;

class Component extends Primitive implements HooksIntoLifecycle
{
    use Definable;
    use Encodable;
    use HasLifecycleHooks;
    use HasMeta;
    use HasName;
    use HasPipeline;
    use HasQuery;
    use HasType;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'component';

    public function __construct()
    {
        parent::__construct();

        $this->define();
    }

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
     * @return $this
     */
    protected function definition(): static
    {
        return $this->name('component');
    }

    /**
     * Get the pipes to be used..
     *
     * @return array<int,class-string<\Honed\Core\Pipe<$this>>>
     */
    protected function pipes(): array
    {
        return [
            CallsBefore::class,
            SetType::class,
            CallsAfter::class,
        ];
    }

    /**
     * Provide a selection of default dependencies for evaluation by name.
     *
     * @return array<int,mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return match ($parameterName) {
            'user' => [User::query()->first()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * Provide a selection of default dependencies for evaluation by type.
     *
     * @param  class-string  $parameterType
     * @return array<int,mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    {
        return match ($parameterType) {
            User::class => [User::query()->first()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }
}
