<?php

declare(strict_types=1);

namespace Honed\Refine\Pipes;

/**
 * @template TClass of \Honed\Refine\Refine
 * 
 * @extends Pipe<TClass>
 */
class SearchQuery extends Pipe
{
    /**
     * Run the search query logic.
     *
     * @param  TClass  $instance
     * @return void
     */
    public function run($instance)
    {
        [$term, $columns] = $this->getValues($instance);

        $instance->term($term);

        match (true) {
            $instance->isScout() => $this->scout($instance),
            default => $this->search($instance, $columns)
        };
    }

    /**
     * Set the search term, and if applicable, the search columns on the instance.
     * 
     * @param  TClass  $instance
     * @return void
     */
    protected function getValues($instance)
    {

    }

    /**
     * Perform the search using Scout.
     * 
     * @param  TClass  $instance
     * @return void
     */
    protected function scout($instance)
    {
        $model = $instance->getModel();

        // Don't search if there is no term.
        if (! $term = $instance->getTerm()) {
            return;
        }

        $builder = $instance->getBuilder();

        $builder->whereIn(
            $builder->qualifyColumn($model->getKeyName()),
            // @phpstan-ignore-next-line method.notFound
            $model->search($term)->keys()
        );
    }

    /**
     * Perform the search using the default search logic.
     * 
     * @param  TClass  $instance
     * @return void
     */
    protected function search($instance, $columns)
    {
        $builder = $instance->getBuilder();
        
        $term = $instance->getTerm();

        $applied = false;

        foreach ($instance->getSearches() as $search) {
            if ($search->handle($builder, $term, $columns, $applied)) {
                $applied = true;
            }
        }
    }
}