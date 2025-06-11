<?php

declare(strict_types=1);

namespace Honed\Action\Presets;

use Honed\Action\Contracts\Actionable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TAttach of \Illuminate\Database\Eloquent\Model
 */
abstract class AttachAction implements Actionable
{
    use Concerns\CanBeTransaction;

    /**
     * Get the relation name, must be a many-to-many relationship.
     * 
     * @return string
     */
    abstract protected function relation();

    /**
     * Get the relation for the model.
     * 
     * @param TModel $model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<TModel, TAttach>
     */
    protected function getRelation($model)
    {
        /** @var \Illuminate\Database\Eloquent\Relations\BelongsToMany<TModel, TAttach> */
        return $model->{$this->relation()}();
    }

    /**
     * Attach models to the .
     * 
     * @param TModel $attachee
     * @param int|string|TAttach|array<int, int|string|TAttach> $attachment
     * @param array<int|string, mixed>|\Illuminate\Support\ValidatedInput|\Illuminate\Foundation\Http\FormRequest $attributes
     * 
     * @return void
     */
    public function handle($model, $attachments, $attributes = [])
    {
        if ($attributes instanceof FormRequest) {
            /** @var \Illuminate\Support\ValidatedInput */
            $attributes = $attributes->safe();
        }

        $this->transact(
            fn () => $this->attach($model, $attachments, $attributes)
        );
    }

    protected function attach($model, $attachments, $attributes)
    {
        $attaching = $this->prepare($attachments, $attributes);

        $this->getRelation($model)->attach($attaching);

        $this->after($model, $attachments, $attaching);
    }

    /**
     * Perform any actions after the model has been attached.
     * 
     * @param TModel $model
     * @param (TArray is true ? array<int, scalar|TAttach> : scalar|TAttach) $attachment
     * @param (TArray is true ? mixed[] : mixed) $prepared
     * 
     * @return void
     */
    protected function after($model, $attachment, $prepared)
    {
        //
    }
}
