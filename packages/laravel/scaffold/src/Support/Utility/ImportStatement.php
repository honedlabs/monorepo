<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support\Utility;

class ImportStatement
{
    /**
     * The import to be written.
     * 
     * @var string
     */
    protected $import;

    /**
     * Set the import.
     * 
     * @return $this
     */
    public function import(string $import): static
    {
        $this->import = $import;

        return $this;
    }

    /**
     * Get the raw import class.
     */
    public function getImport(): string
    {
        return $this->import;
    }

    /**
     * Write the lines for the statement.
     */
    public function write(Writer $writer)
    {
        return $writer
            ->line("use {$this->getImport()};");
    }
}