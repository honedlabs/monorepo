<?php

declare(strict_types=1);

namespace Honed\Refine\Pipes;

use Honed\Core\Interpret;
use Honed\Core\Pipe;
use Honed\Refine\Stores\Data\SearchData;
use InvalidArgumentException;

/**
 * @template TClass of \Honed\Refine\Contracts\RefinesData
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
        if (! $instance->isSearchable()) {
            return;
        }

        [$term, $columns] = $this->getValues($instance);

        $instance->setTerm($term);

        match (true) {
            $instance->isScout() => $this->scout($instance),
            default => $this->search($instance, $columns)
        };

        $this->persist($instance, $term, $columns);
    }

    /**
     * Set the search term, and if applicable, the search columns on the instance.
     *
     * @param  TClass  $instance
     * @return array{string|null, array<int,string>|null}
     */
    public function getValues($instance)
    {
        $request = $instance->getRequest();

        $key = $instance->getSearchKey();

        $term = Interpret::string($request, $key);

        return match (true) {
            (bool) $term => [
                str_replace('+', ' ', trim($term)),
                $this->getColumns($instance),
            ],
            $request->missing($key) => $this->persisted($instance),
            default => [null, null]
        };
    }

    /**
     * Get the search columns from the instance's request.
     *
     * @param  TClass  $instance
     * @return array<int,string>|null
     */
    public function getColumns($instance)
    {
        if (! $instance->isMatchable()) {
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
     * @param  string|null  $term
     * @param  array<int,string>|null  $columns
     * @return void
     */
    public function persist($instance, $term, $columns)
    {
        $instance->getSearchStore()?->put([
            $instance->getSearchKey() => [
                'term' => $term,
                'cols' => $columns ?? [],
            ],
        ]);
    }

    /**
     * Get the search data from the store.
     *
     * @param  TClass  $instance
     * @return array{string|null, array<int, string>|null}
     */
    protected function persisted($instance)
    {
        try {
            $data = SearchData::from(
                $instance->getSearchStore()?->get($instance->getSearchKey())
            );

            $columns = $instance->isMatchable() ? $data->columns : null;

            return [$data->term, $columns];
        } catch (InvalidArgumentException) {
            return [null, null];
        }
    }
}
