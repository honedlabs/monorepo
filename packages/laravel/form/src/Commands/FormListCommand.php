<?php

declare(strict_types=1);

namespace Honed\Form\Commands;

use Honed\Core\Commands\ListCommand;
use Honed\Form\Form;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'form:list')]
class FormListCommand extends ListCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'form:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all form classes';

    /**
     * Get the paths to search for classes.
     *
     * @return string|array<int, string>
     */
    protected function paths(): string|array
    {
        return app_path('Forms');
    }

    /**
     * Determine if the class should be ignored.
     */
    protected function ignore(string $class): bool
    {
        return parent::ignore($class) || ! is_subclass_of($class, Form::class);
    }
}
