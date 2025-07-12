<?php

declare(strict_types=1);

namespace Honed\Action\Actions\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Workbench\App\Models\Product;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TAttach of \Illuminate\Database\Eloquent\Model
 * 
 * @phpstan-require-implements \Honed\Action\Contracts\Relatable
 * @phpstan-require-extends \Honed\Action\Actions\DatabaseAction
 */
trait Attachable
{
    /**
     * Get the relation for the model.
     *
     * @param  TModel  $model
     * @return BelongsToMany<TModel, TAttach>
     */
    public function getRelationship(Model $model): Relation
    {
        /** @var BelongsToMany<TModel, TAttach> */
        return $model->{$this->relationship()}();
    }

    /**
     * @template T of int|string|TAttach|null
     * 
     * @param  T|array<int, T>|\Illuminate\Support\Collection<int, T>  $ids
     * @return array<int, int|string>
     */
    public function parseIds($ids)
    {
        return match (true) {
            $ids instanceof Collection => $ids->toArray(),
            is_array($ids) => $ids,
            default => Arr::wrap($ids),
        };
    }
}