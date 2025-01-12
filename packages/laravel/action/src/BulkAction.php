<?php

declare(strict_types=1);

namespace Honed\Action;

use Illuminate\Support\Collection;
use Honed\Action\Contracts\HandlesAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BulkAction extends Action
{
    use Concerns\HasAction;
    use Concerns\ChunksBuilder;

    public function setUp(): void
    {
        $this->type(Creator::Bulk);
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'action' => $this->hasAction(),
        ]);
    }

    /**
     * Execute the action handler using the provided data.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\RedirectResponse|void
     */
    public function execute($builder)
    {
        if (! $this->hasAction()) {
            return;
        }

        $handler = $this instanceof HandlesAction;

        [$model, $singular, $plural] = $this->getActionParameterNames($builder);

        $callback = $handler 
            ? [$this, 'handle'] 
            : $this->getAction();

        $parameters = $handler 
            ? $this->getHandleParameters()
            : (new \ReflectionFunction($callback))->getParameters();

        $retrieveRecords = $this->isCollectionCallback(
            $parameters,
            $plural,
        );

        $singularAccess = $this->isModelCallback(
            $parameters,
            $model,
            $singular,
        );

        return match (true) {
            $this->chunks() => $this->chunkRecords($builder, $callback, $singularAccess),

            $retrieveRecords && $handler => \call_user_func($callback, $builder->get()),

            $retrieveRecords => $this->evaluateCallbackWithRecords($builder, $callback, $plural),
            
            $singularAccess => $builder->get()->each(fn ($model) => \call_user_func($callback, $model)),

            $handler => \call_user_func($callback, $builder),

            default => $this->evaluate($callback, [
                'query' => $builder,
                'builder' => $builder,
            ], [
                Builder::class => $builder,
            ]),
        };
    }

    /**
     * Retrieve the parameter names for the action.
     * 
     * @return array{0: \Illuminate\Database\Eloquent\Model, 1: string, 2: string}
     */
    private function getActionParameterNames(Builder $builder): array
    {
        $model = $builder->getModel();
        $table = $model->getTable();

        return [
            $model,
            str($table)->camel()->singular()->toString(),
            str($table)->camel()->toString(),
        ];
    }

    /**
     * Evaluate the action handler with retrieved records.
     */
    private function evaluateCallbackWithRecords(Builder $builder, \Closure $callback, string $plural): void
    {
        $records = $builder->get();

        $this->evaluate($callback, [
            'records' => $records,
            'collection' => $records,
            $plural => $records,
        ], [
            Collection::class => $records,
        ]);
    }

    /**
     * Retrieve the parameters for the handle method.
     * 
     * @return array<int,\ReflectionParameter>
     */
    private function getHandleParameters(): array
    {
        return collect((new \ReflectionClass($this))->getMethods())
            ->first(fn (\ReflectionMethod $method) => $method->getName() === 'handle')
            ->getParameters();
    }

    /**
     * Determine if the action executable requires the records to be retrieved.
     * 
     * @param array<int,\ReflectionParameter> $parameters
     */
    private function isCollectionCallback(array $parameters, string $plural): bool
    {
        return collect($parameters)
            ->some(fn (\ReflectionParameter $parameter) => 
                ($t = $parameter->getType()) instanceof \ReflectionNamedType && \in_array($t->getName(), [Collection::class])
                    || \in_array($parameter->getName(), ['records', 'collection', $plural])
            );
    }

    /**
     * Determine if the action executable requires a model to be retrieved, and then acts on individual collection records.
     * 
     * @param array<int,\ReflectionParameter> $parameters
     */
    private function isModelCallback(array $parameters, Model $model, string $singular): bool
    {
        return collect($parameters)
        ->some(fn (\ReflectionParameter $parameter) => 
            ($t = $parameter->getType()) instanceof \ReflectionNamedType && \in_array($t->getName(), [Model::class, $model::class])
                || \in_array($parameter->getName(), ['model', 'record', $singular])
        );
    }
}