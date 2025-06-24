<?php

declare(strict_types=1);

namespace Honed\Table\Commands;

use Honed\Table\ViewManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'views:purge', aliases: ['views:clear'])]
class PurgeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'views:purge
                            {tables?* : The tables to purge}
                            {--except=* : The tables that should be excluded from purging}
                            {--except-registered : Purge all tables except those registered}
                            {--store= : The store to purge the tables from}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete views from storage';

    /**
     * The console command name aliases.
     *
     * @var array
     */
    protected $aliases = ['views:clear'];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ViewManager $manager)
    {
        $store = $manager->store($this->option('store'));

        // $features = $this->argument('features') ?: null;

        // $except = collect($this->option('except'))
        //     ->when($this->option('except-registered'), fn ($except) => $except->merge($store->defined()))
        //     ->unique()
        //     ->all();

        // if ($except) {
        //     $features = collect($features ?: $store->stored())
        //         ->flip()
        //         ->forget($except)
        //         ->flip()
        //         ->values()
        //         ->all();
        // }

        // $store->purge($table);

        // if ($features) {
        //     $this->components->info(implode(', ', $features).' successfully purged from storage.');
        // } elseif ($except) {
        //     $this->components->info('No features to purge from storage.');
        // } else {
        //     $this->components->info('All features successfully purged from storage.');
        // }

        return self::SUCCESS;
    }
}
