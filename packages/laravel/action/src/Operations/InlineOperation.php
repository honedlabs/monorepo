<?php

declare(strict_types=1);

namespace Honed\Action\Operations;

use Honed\Core\Concerns\HasRecord;
use Honed\Core\Concerns\IsDefault;
use Illuminate\Database\Eloquent\Model;

class InlineOperation extends Operation
{
    use HasRecord;
    use IsDefault;

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->type(self::INLINE);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            ...parent::toArray(),
            'default' => $this->isDefault(),
        ];
    }

    /**
     * Execute the inline action on the given record.
     *
     * @param  array<string, mixed>|Model  $record
     * @return mixed
     */
    public function execute($record)
    {
        $handler = $this->getHandler();

        if (! $handler) {
            return;
        }

        $this->record($record);

        return $this->evaluate($handler);
    }

    /**
     * Define the inline operation instance.
     *
     * @param  $this  $operation
     * @return $this
     */
    protected function definition(self $operation): self
    {
        return $operation;
    }

    /**
     * Provide a selection of default dependencies for evaluation by name.
     *
     * @param  string  $parameterName
     * @return array<int, mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        return match ($parameterName) {
            'model', 'record', 'row' => [$this->getRecord()],
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
