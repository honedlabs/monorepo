<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use SplFileInfo;
use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;

use Illuminate\Support\Facades\File;
use function Laravel\Prompts\suggest;
use Honed\Action\ActionServiceProvider;
use Honed\Scaffold\Scaffolders\Scaffolder;
use Honed\Scaffold\Properties\DateProperty;

class ActionScaffolder extends Scaffolder
{
    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return class_exists(ActionServiceProvider::class);
    }

    /**
     * Prompt the user for input.
     */
    public function suggest(): void
    {
        $actions = multiselect(
            label: 'Select which actions to scaffold for the model.',
            options: [
                'create' => 'Create',
                'update' => 'Update',
                'delete' => 'Delete',
                'restore' => 'Restore',
            ]
        );
    }
}