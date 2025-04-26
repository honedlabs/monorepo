<?php

declare(strict_types=1);

namespace Honed\Command\Concerns;

use Honed\Command\Attributes\Repository as RepositoryAttribute;
use Honed\Command\Repository;

/**
 * @template TRepository of \Honed\Command\Repository
 * 
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasRepository
{
    /**
     * The repository manager instance.
     *
     * @var class-string<TRepository>
     */
    protected static $repository;

    /**
     * Get the repository manager instance.
     *
     * @return TRepository
     */
    public static function repository()
    {
        return static::newRepository()
            ?? Repository::repositoryForModel(static::class);
    }

    /**
     * Create a new repository instance for the model.
     *
     * @return TRepository|null
     */
    protected static function newRepository()
    {
        if (isset(static::$repository)) {
            return new static::$repository;
        }

        if ($repository = static::getRepositoryAttribute()) {
            return new $repository;
        }

        return null;
    }

    /**
     * Get the repository from the Repository class attribute.
     *
     * @return class-string<TRepository>|null
     */
    protected static function getRepositoryAttribute()
    {
        $attributes = (new \ReflectionClass(static::class))
            ->getAttributes(RepositoryAttribute::class);

        if ($attributes !== []) {
            $repository = $attributes[0]->newInstance();

            return $repository->repository;
        }

        return null;
    }
}
