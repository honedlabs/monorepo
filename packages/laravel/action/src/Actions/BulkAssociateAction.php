<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Honed\Action\Contracts\Relatable;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TParent of \Illuminate\Database\Eloquent\Model
 */
abstract class BulkAssociateAction extends DatabaseAction implements Relatable
{
    // use Associative;

    /**
     * Get the associate action to use.
     * 
     * @return class-string<\Honed\Action\Actions\AssociateAction>
     */
    abstract public function associate(): string;

    public function handle($models, $parents)
    {
        return $this->transact(
            fn () => $this->associative($model, $parents)
        );
    }

    protected function associative(Model $model, $parents)
    {


    }
}