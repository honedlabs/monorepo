<?php

namespace {{ namespace }};

use Honed\Command\Repository;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 */
class {{ class }} extends Repository
{
    /**
     * Create a new repository instance.
     * 
     * @param  TModel {{ model }}
     */
    public function __construct(
        protected {{ modelClass }} ${{ model }}
    ) { }

    /**
     * Get all the models.
     * 
     * @return TBuilder
     */
    public function index()
    {
        return $this->{{ model }}->query();
    }

    /**
     * Create a new {{ model }} instance.
     * 
     * @param  array<string,mixed>  $attributes
     * @return TModel
     */
    public function store($attributes = [])
    {
        return {{ modelClass }}::query()
            ->create([

            ]);
    }

    /**
     * Get the {{ model }} by its id.
     * 
     * @param  int  $id
     * @return TModel|null
     */
    public function show($id)
    {
        return {{ modelClass }}::query()
            ->find($id);
    }

    /**
     * Update the {{ model }} by its id.
     * 
     * @param  int|string  $id
     * @param  array<string,mixed>  $attributes
     * @return TModel
     */
    public function update($id, $attributes = [])
    {
        return {{ modelClass }}::query()
            ->find($id)
            ?->update($attributes);
    }

    /**
     * Delete the {{ model }} by its id.
     * 
     * @param  int|string  $id
     * @return bool
     */
    public function destroy($id)
    {
        return {{ modelClass }}::query()
            ->find($id)
            ?->delete();
    }
}