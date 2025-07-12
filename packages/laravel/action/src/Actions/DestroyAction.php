<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Contracts\RequiresModel;
use Illuminate\Support\Collection;
use Workbench\App\Models\Product;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * 
 * @implements \Honed\Action\Contracts\RequiresModel<TModel>
 */
abstract class DestroyAction extends DatabaseAction implements RequiresModel
{
    /**
     * Destroy the given ids.
     *
     * @template T of int|string|TModel|null
     * 
     * @param T|array<int, T>|\Illuminate\Support\Collection<int, T> $ids
     */
    public function handle($ids): void
    {
        $this->transaction(
            fn () => $this->execute($ids)
        );
    }

    /**
     * Destroy the model(s).
     *
     * @template T of int|string|TModel|null
     * 
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T> $ids
     */
    protected function execute($ids): void
    {
        $this->model()::destroy($ids ?? []);

        $this->after($ids);
    }

    /**
     * Perform additional logic after the action has been executed.
     *
     * @template T of int|string|TModel|null
     * 
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T> $ids
     */
    protected function after($ids): void
    {
        //
    }
}
