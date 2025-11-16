<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Illuminate\Support\Collection;

trait HasImports
{
    /**
     * The imports to be added.
     *
     * @var Collection<int, ImportStatement>
     */
    protected $imports;

    /**
     * Add an import to the context.
     */
    public function addImport(string $import): void
    {
        $this->imports->push($import);
    }

    /**
     * Add multiple imports to the context.
     *
     * @param  list<ImportStatement>  $imports
     */
    public function addImports(array $imports): void
    {
        $this->imports->push(...$imports);
    }

    /**
     * Get the imports for the context.
     *
     * @return Collection<int, string>
     */
    public function getImports(): Collection
    {
        return $this->imports;
    }

    /**
     * Initialize the imports.
     */
    protected function initializeImports(): void
    {
        $this->imports = new Collection();
    }
}
