<?php

declare(strict_types=1);

namespace Honed\Billing\Commands;

use Honed\Billing\Schema;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'billing:list', aliases: ['list:billing'])]
class ListProductsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'billing:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List the products from the billing schema.';

    /**
     * The console command name aliases.
     *
     * @var array<int, string>
     */
    protected $aliases = ['list:billing'];

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

        return self::SUCCESS;
    }
}
