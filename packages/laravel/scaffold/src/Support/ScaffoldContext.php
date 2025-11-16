<?php

declare(strict_types=1);

namespace Honed\Scaffold\Support;

use Honed\Core\Concerns\HasName;
use Honed\Scaffold\Collections\ScaffolderCollection;
use Honed\Scaffold\Concerns\HasCommands;
use Honed\Scaffold\Concerns\HasImports;
use Honed\Scaffold\Concerns\HasInterfaces;
use Honed\Scaffold\Concerns\HasMethods;
use Honed\Scaffold\Concerns\HasProperties;
use Honed\Scaffold\Concerns\HasTraits;
use Honed\Scaffold\Contracts\ScaffoldContext as ScaffoldContextContract;
use Honed\Scaffold\Contracts\Scaffolder;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ScaffoldContext implements ScaffoldContextContract
{
    use HasCommands;
    use HasImports;
    use HasInterfaces;
    use HasMethods;
    use HasName;
    use HasProperties;
    use HasTraits;

    /**
     * The traits to be used.
     *
     * @var Collection<int, PendingTrait>
     */
    protected $traits;

    public function __construct(string $name)
    {
        $this->name = $name;

        $this->initializeImports();
        $this->initializeProperties();
        $this->initializeCommands();
        $this->initializeInterfaces();
        $this->initializeTraits();
        $this->initializeMethods();
    }

    /**
     * Create a new scaffold context instance.
     */
    public static function make(string $name): static
    {
        return app(static::class, ['name' => $name]);
    }

    /**
     * Get the scaffolders to be used.
     *
     * @return list<Scaffolder>
     */
    public function getScaffolders(Command $command): array
    {
        // @phpstan-ignore-next-line
        return (new ScaffolderCollection(config()->array('scaffold.scaffolders', [])))
            ->build($this, $command)
            ->toArray();
    }

    /**
     * Scaffold the context.
     */
    public function generate(): void
    {
        // $this->callCommands();

        // $this->implementInterfaces();

        dd($this);

        // $this->getMethods()->each->handle($this);

        // $this->getTraits()->each->handle($this);
    }

    /**
     * Call the commands.
     */
    protected function callCommands(): void
    {
        // $this->getCommands()->each(function (PendingCommand $command) {
        //     Artisan::call($command->getName(), $command->getArguments());
        // });
    }

    /**
     * Implement the interfaces.
     */
    protected function implementInterfaces(): void
    {
        //
    }

    /**
     * Use the traits.
     */
    protected function useTraits(): void
    {
        //
    }

    /**
     * Add the methods.
     */
    protected function addMethods(): void
    {
        //
    }
}
