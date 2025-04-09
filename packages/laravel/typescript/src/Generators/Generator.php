<?php

declare(strict_types=1);

namespace Honed\Typescript\Generators;

abstract class Generator
{
    public function __construct(
        protected \ReflectionClass $reflection
    ) { }

    /**
     * The filename to output the TypeScript definitions to.
     * 
     * @return string
     */
    abstract public function outputFile();

    /**
     * The file patterns to look for.
     * 
     * @return string|array<int,string>
     */
    abstract public function glob();

    public function generate()
    {

    }

    /**
     * Get the class name to use for the TypeScript definition.
     * 
     * @return string
     */
    public function tsClassName()
    {
        return \str_replace('\\', '.', $this->reflection->getShortName());
    }

}