<?php

declare(strict_types=1);

namespace Honed\Action;

use Illuminate\Support\Collection;
use Honed\Core\Contracts\HigherOrder;
use Honed\Action\Contracts\HandlesAction;
use Honed\Action\Tests\Stubs\Product;
use Honed\Core\Contracts\ProxiesHigherOrder;

class BulkAction extends Action
{
    use Concerns\HasAction;

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


        $model = $data->getModel();
        $parameters = str($model->getTable())->camel()->toString();
        $parameter = str($parameters)->singular()->toString();

        $needsCollection = collect(
            collect((new \ReflectionClass($this))->getMethods())
                ->first(fn (\ReflectionMethod $method) => $method->getName() === 'handle')
                ->getParameters()
            )->some(fn (\ReflectionParameter $parameter) => 
                ($t = $parameter->getType()) instanceof \ReflectionNamedType && $t->getName() === Collection::class
                    || \in_array($parameter->getName(), ['records', $parameters])
            )
        );

        return $this instanceof HandlesAction
            ? $this->handle($data)
            : $this->evaluate($this->getAction(), [
                'data' => $data,
            ]);
    }

    public function handle($products)
    {
        //
    }
}