<?php

declare(strict_types=1);

namespace Honed\Action;

use Illuminate\Support\Collection;
use Honed\Core\Contracts\HigherOrder;
use Honed\Action\Contracts\HandlesAction;
use Honed\Action\Tests\Stubs\Product;
use Honed\Core\Contracts\ProxiesHigherOrder;
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
            // 'confirm' => $this->confirm(),
            // 'deselect' => $this->deselect(),
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
        // if (! $this->hasAction()) {
        //     return;
        // }

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
        dd($builder);

        return $this->evaluate($this->getAction(), [
            'data' => $builder,
        ]);
    }

    /**
     * Retrieve the parameter names for the action.
     * 
     * @return array{0: \Illuminate\Database\Eloquent\Model, 1: string, 2: string}
     */
    private function getActionParameterNames(Builder $builder): array
    {
        $table = $builder->getTable();

        return [
            $builder->getModel(),
            str($table)->camel()->singular()->toString(),
            str($table)->camel()->toString(),
        ];
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
    private function selectsRecords(array $parameters): bool
    {
        return collect($this->getHandleParameters())
            ->some(fn (\ReflectionParameter $parameter) => 
                ($t = $parameter->getType()) instanceof \ReflectionNamedType && \in_array($t->getName(), [Collection::class, Model::class, $model])
                    || \in_array($parameter->getName(), ['records', $parameters])
            );
    }

    public function handle($products)
    {
        //
    }
}