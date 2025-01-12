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
     * @param \Illuminate\Database\Eloquent\Builder $data
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\RedirectResponse|void
     */
    public function execute($data)
    {
        if (! $this->hasAction()) {
            return;
        }

        return $this instanceof HandlesAction
            ? $this->executeHandler($data)
            : $this->executeCallback($data);
    }

    private function executeHandler(Builder $builder)
    {
        return $this->handle($builder);
    }

    private function executeCallback(Builder $builder)
    {
        [$model, $singular, $plural] = $this->getActionParameterNames($builder);

        $callback = $this->getAction();

        $selects = $this->isCollectionCallback(
            (new \ReflectionFunction($callback))->getParameters(),
            $plural,
        );

        $callsModel = $this->isModelCallback(
            (new \ReflectionFunction($callback))->getParameters(),
            $model,
            $singular,
        );

        return match (true) {
            $this->chunks() => $this->chunkRecords($builder, $callback, $callsModel),

            $selects => $this->withRecords($builder, $callback, $plural),

            $callsModel => $builder->get()->each(fn ($model) => \call_user_func($callback, $model)),

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
    private function withRecords(Builder $builder, \Closure $callback, string $plural): void
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