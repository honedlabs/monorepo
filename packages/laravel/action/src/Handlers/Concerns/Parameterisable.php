<?php

declare(strict_types=1);

namespace Honed\Action\Handlers\Concerns;

use Illuminate\Database\Eloquent\Model;

trait Parameterisable
{
    /**
     * The named parameters.
     * 
     * @var array<string,mixed>
     */
    protected array $named = [];

    /**
     * The typed parameters.
     * 
     * @var array<class-string,mixed>
     */
    protected array $typed = [];

    /**
     * Parameterise the resource.
     * 
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $resource
     * @return void
     */
    public function parameterise($resource): void
    {
        $this->named = $this->getNamedParameters($resource);
        $this->typed = $this->getTypedParameters($resource);
    }

    /**
     * Get the named parameters.
     * 
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $resource
     * @return array<string,mixed>
     */
    protected function getNamedParameters($resource)
    {
        if (! $resource) {
            return [];
        }

        return array_fill_keys(
            ['model', 'record', 'row'],
            $resource
        );
    }

    /**
     * Get the typed parameters.
     * 
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $resource
     * @return array<class-string,mixed>
     */
    protected function getTypedParameters($resource)
    {
        if (! $resource || ! $resource instanceof Model) {
            return [];
        }

        return array_fill_keys(
            [Model::class, $resource::class],
            $resource
        );
    }
}