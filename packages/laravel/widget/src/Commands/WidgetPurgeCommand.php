<?php

declare(strict_types=1);

namespace Honed\Widget\Commands;

use Honed\Widget\WidgetManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'widgets:purge', aliases: ['widgets:clear'])]
class WidgetPurgeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'widgets:purge
        {widgets?* : The widgets to purge}
        {--store= : The store to purge the widgets from}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete widgets from storage';

    /**
     * The console command name aliases.
     *
     * @var array<int, string>
     */
    protected $aliases = ['widgets:clear'];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(WidgetManager $manager)
    {
        /** @var string|null */
        $store = $this->option('store');

        $store = $manager->store($store);

        /** @var array<int, class-string<\Honed\Table\Table>>|null $widgets */
        $widgets = $this->argument('widgets') ?: null;

        if ($widgets) {
            // $widgets = array_map(
            //     static fn ($widget) => Widgets::serializeTable($widget),
            //     (array) $widgets
            // );
        }

        $store->purge($widgets);

        if ($widgets) {
            $this->components->info(implode(', ', $widgets).' successfully purged from storage.');
        } else {
            $this->components->info('All widgets successfully purged from storage.');
        }

        return self::SUCCESS;
    }
}