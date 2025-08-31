<?php

declare(strict_types=1);

namespace Workbench\App\Console\Commands;

use BackedEnum;
use Honed\Core\Primitive;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Commands\ListCommand;
use Honed\Core\Contracts\HooksIntoLifecycle;

use function Orchestra\Testbench\workbench_path;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'list:components')]
class ComponentListCommand extends ListCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:components';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all components';

    /**
     * {@inheritdoc}
     */
    protected function paths(): string|array
    {
        return workbench_path('app/Classes');
    }

    /**
     * Get the application namespace.
     */
    protected function namespace(): string
    {
        return 'Workbench\\App\\';
    }

    /**
     * Get the application namespace.
     */
    protected function basePath(): string
    {
        return workbench_path();
    }

    /**
     * {@inheritdoc}
     */
    protected function ignore(string $class): bool
    {
        return parent::ignore($class)
            || $this->doesNotImplement($class, HooksIntoLifecycle::class)
            || $this->doesNotExtend($class, Primitive::class)
            || $this->doesNotUse($class, HasMeta::class);
    }
}