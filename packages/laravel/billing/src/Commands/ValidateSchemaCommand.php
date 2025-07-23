<?php

declare(strict_types=1);

namespace Honed\Billing\Commands;

use Honed\Billing\Schema;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'billing:validate', aliases: ['validate:billing'])]
class ValidateSchemaCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'billing:validate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate the billing schema from your config file.';

    /**
     * The console command name aliases.
     *
     * @var array<int, string>
     */
    protected $aliases = ['validate:billing'];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $schema = config('billing.products');

        $error = Schema::validate($schema);

        if ($error) {
            $this->components->error($error);

            return self::FAILURE;
        }

        $this->components->info('The billing schema is valid.');

        return self::SUCCESS;
    }
}
