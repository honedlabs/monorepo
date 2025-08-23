<?php

declare(strict_types=1);

namespace Honed\Widget\Commands;

use Closure;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'widget:list')]
class WidgetListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'widget:list
                            {--widget= : Filter the widgets by name}
                            {--json : Output the widgets and listeners as JSON}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "List the application's widgets";

    /**
     * The events dispatcher resolver callback.
     *
     * @var Closure|null
     */
    protected static $widgetsResolver;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $widgets = $this->getWidgets()->sortKeys();

        if ($widgets->isEmpty()) {
            if ($this->option('json')) {
                $this->output->writeln('[]');
            } else {
                $this->components->info("Your application doesn't have any widgets matching the given criteria.");
            }

            return;
        }

        if ($this->option('json')) {
            $this->displayJson($widgets);
        } else {
            $this->displayForCli($widgets);
        }
    }

    /**
     * Display events and their listeners in JSON.
     *
     * @param  Collection  $widgets
     * @return void
     */
    protected function displayJson($widgets)
    {
        $data = $widgets->map(function ($widget) {
            return [
                'widget' => strip_tags($this->appendWidgetInterfaces($widget)),
            ];
        })->values();

        $this->output->writeln($data->toJson());
    }

    /**
     * Display the events and their listeners for the CLI.
     *
     * @return void
     */
    protected function displayForCli(Collection $events)
    {
        $this->newLine();

        $events->each(function ($listeners, $event) {
            $this->components->twoColumnDetail($this->appendEventInterfaces($event));
            $this->components->bulletList($listeners);
        });

        $this->newLine();
    }

    /**
     * Get all of the events and listeners configured for the application.
     *
     * @return Collection
     */
    protected function getWidgets()
    {
        $widgets = new Collection([]);

        if ($this->filteringByWidget()) {
            $widgets = $this->filterWidgets($widgets);
        }

        return $widgets;
    }

    /**
     * Filter the given events using the provided event name filter.
     *
     * @param  Collection  $widgets
     * @return Collection
     */
    protected function filterWidgets($widgets)
    {
        if (! $widgetName = $this->option('widget')) {
            return $widgets;
        }

        return $widgets->filter(
            fn ($listeners, $widget) => str_contains($widget, $widgetName)
        );
    }

    /**
     * Determine whether the user is filtering by an event name.
     *
     * @return bool
     */
    protected function filteringByWidget()
    {
        return filled($this->option('widget'));
    }
}
