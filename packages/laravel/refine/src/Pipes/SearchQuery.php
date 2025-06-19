<?php

declare(strict_types=1);

namespace Honed\Refine\Pipes;

use Honed\Core\Interpret;

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

        $this->persist($instance, $columns);
    }

    /**
     * Set the search term, and if applicable, the search columns on the instance.
     * 
     * @param  TClass  $instance
     * @return array{string|null, array<int,string>|null}
     */
    public function getValues($instance)
    {
        return [
            $this->getTerm($instance),
            $this->getColumns($instance),
        ];
    }

    /**
     * Get the search term from the instance's request.
     * 
     * @param  TClass  $instance
     * @return string|null
     */
    public function getTerm($instance)
    {
        $term = Interpret::string(
            $instance->getRequest(), $instance->getSearchKey()
        );


        return $term ? str_replace('+', ' ', trim($term)) : null;
    }

    /**
     * Get the search columns from the instance's request.
     * 
     * @param  TClass  $instance
     * @return array<int,string>|null
     */
    public function getColumns($instance)
    {
        if ($instance->isNotMatchable()) {
            return null;
        }

        return Interpret::array(
            $instance->getRequest(),
            $instance->getMatchKey(),
            $instance->getDelimiter(),
            'string'
        );
    }

    /**
     * Perform the search using Scout.
     * 
     * @param  TClass  $instance
     * @return void
     */
    public function scout($instance)
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
     * @param  array<int,string>|null  $columns
     * @return bool
     */
    public function search($instance, $columns)
    {
        $builder = $instance->getBuilder();
        
        $term = $instance->getTerm();

        $applied = false;

        foreach ($instance->getSearches() as $search) {
            if ($search->handle($builder, $term, $columns, $applied)) {
                $applied = true;
            }
        }

        return $applied;
    }

    /**
     * Persist the search value to the internal data store.
     * 
     * @param  TClass  $instance
     * @return void
     */
    public function persist($instance, $columns)
    {
        $driver = $instance->getSearchPersistenceDriver();

        if (! $driver) {
            return;
        }

        $driver->put([
            'search' => [
                'term' => $instance->getTerm(),
                ...($instance->isMatchable() && $columns ? ['cols' => $columns] : []),
            ]
        ]);
    }
}