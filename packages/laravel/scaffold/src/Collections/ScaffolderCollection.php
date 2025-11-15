<?php

declare(strict_types=1);

namespace Honed\Scaffold\Collections;

use Honed\Scaffold\Contracts\Scaffolder;
use Honed\Scaffold\Support\ScaffoldContext;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Support\Collection<int, class-string<\Honed\Scaffold\Contracts\Scaffolder>>
 */
class ScaffolderCollection extends Collection
{
    /**
     * Build the scaffolders.
     */
    public function build(ScaffoldContext $context, Command $command): static
    {
        return $this->map(
            fn (string $className): Scaffolder => app($className, [
                'context' => $context,
                'components' => $command->outputComponents(),
            ])
        );
    }
}
