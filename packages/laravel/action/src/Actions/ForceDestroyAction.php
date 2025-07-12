<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Contracts\FromModel;
use Illuminate\Support\Collection;
use Workbench\App\Models\Product;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * 
 * @implements \Honed\Action\Contracts\FromModel<TModel>
 */
abstract class ForceDestroyAction extends DatabaseAction implements FromModel
{
    /**
     * Force destroy the given ids.
     *
     * @template T of int|string
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
     * Execute the action.
     *
     * @template T of int|string
     * 
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T> $ids
     */
    protected function execute($ids): void
    {
        $this->from()::forceDestroy($ids);

        $this->after($ids);
    }

    /**
     * Perform additional logic after the action has been executed.
     *
     * @template T of int|string
     * 
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T> $ids
     */
    protected function after($ids): void
    {
        //
    }
}
