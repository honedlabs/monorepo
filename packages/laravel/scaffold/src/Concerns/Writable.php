<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

trait Writable
{
    /**
     * The lines of the file to be written.
     * 
     * @var list<string>
     */
    protected $lines = [];

    /**
     * Add a line.
     * 
     * @return $this
     */
    public function line(string $line = ''): static
    {
        $this->lines[] = $line;

        return $this;
    }

    /**
     * Add a return statement, adding the semicolon.
     * 
     * @return $this
     */
    public function return(string $return = ''): static
    {
        return $this->line("return {$return};");
    }
}