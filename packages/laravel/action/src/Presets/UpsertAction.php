<?php

declare(strict_types=1);

namespace Honed\Action\Presets;

use Honed\Action\Contracts\Actionable;
use Honed\Action\Tests\Stubs\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\ValidatedInput;
use Workbench\App\Models\User;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
abstract class UpdateAction implements Actionable
{
    use Concerns\CanBeTransaction;

    /**
     * Get the model to perform the upsert on.
     * 
     * @return class-string<TModel>
     */
    abstract protected function for();

    /**
     * Get the unique by columns for the upsert.
     * 
     * @return array<int, string>
     */
    abstract protected function uniqueBy();

    /**
     * Get the columns to update in the upsert.
     * 
     * @return array<int, string>
     */
    abstract protected function update();

    /**
     * Upsert the input data in the database.
     * 
     * @param array<int, array<string, mixed>>|\Illuminate\Support\ValidatedInput|\Illuminate\Foundation\Http\FormRequest $values
     * @return void
     */
    public function handle($values)
    {
        if ($values instanceof FormRequest) {
            /** @var \Illuminate\Support\ValidatedInput */
            $values = $values->safe();
        }

        $this->transact(
            fn () => $this->upsert($values)
        );
    }

    /**
     * Prepare the input for the update method.
     * 
     * @param array<int, array<string, mixed>>|\Illuminate\Support\ValidatedInput $values
     * @return array<int, array<string, mixed>>
     */
    protected function prepare($values)
    {
        if ($values instanceof ValidatedInput) {
            /** @var array<string, mixed> */
            $all = $values->all();

            return [$all];
        }

        return $values;
    }

    /**
     * Upsert the record in the database.
     * 
     * @param array<int, array<string, mixed>>|\Illuminate\Support\ValidatedInput $values
     * @return void
     */
    protected function upsert($values)
    {
        $prepared = $this->prepare($values);

        $class = $this->for();

        (new $class)->query()
            ->upsert($prepared, $this->uniqueBy(), $this->update());

        $this->after($values, $prepared);
    }

    /**
     * Perform additional database transactions after the model has been updated.
     * 
     * @param array<int, array<string, mixed>>|\Illuminate\Support\ValidatedInput $values
     * @param array<int, array<string, mixed>> $prepared
     * @return void
     */
    protected function after($values, $prepared)
    {
        //
    }
}

