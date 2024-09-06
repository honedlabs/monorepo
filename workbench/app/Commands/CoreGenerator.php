<?php

namespace Workbench\App\Commands;

use Conquest\Core\Commands\GeneratorCommand;

class CoreGenerator extends GeneratorCommand
{
    protected $type = 'Core';

    /** Proxy methods for ManipulatesFiles */
    public function proxyCheckForCollision(array|string $paths): bool
    {
        return $this->checkForCollision($paths);
    }

    public function proxyWriteFile(string $path, string $contents): void
    {
        $this->writeFile($path, $contents);
    }

    public function proxyFileExists(string $path): bool
    {
        return $this->fileExists($path);
    }

    public function proxyCopyStubToApp(string $stub, string $targetPath, string $before, array $replacements = []): void
    {
        $this->copyStubToApp($stub, $targetPath, $before, $replacements);
    }

    /** Proxy methods for GeneratorCommand */
    public function proxyGetArguments(): array
    {
        return $this->getArguments();
    }

    public function proxyGetOptions(): array
    {
        return $this->getOptions();
    }

    public function proxyGetDefaultStubPath(): string
    {
        return $this->getDefaultStubPath();
    }

    public function proxyPromptForMissingArgumentsUsing()
    {
        return $this->promptForMissingArgumentsUsing();
    }
}
