<?php

declare(strict_types=1);

namespace Honed\Binding\Commands;

use Honed\Binding\BindingServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'binding:cache')]
class BindingCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'binding:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Discover and cache the available route model binding methods for the application.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->callSilent('binding:clear');

        $this->components->info('Caching bindings...');

        $bindings = $this->getBindings();

        $progress = $this->output->createProgressBar(count($bindings, COUNT_RECURSIVE));

        /** @var array<class-string<\Illuminate\Database\Eloquent\Model>, array<string, class-string<\Honed\Binding\Binder>>> */
        $content = [];

        foreach ($bindings as $binding) {
            /** @var \Honed\Binding\Binder $binding */
            $binding = App::make($binding);

            $binds = array_fill_keys($binding->bindings(), get_class($binding));

            $content[$binding->modelName()] = array_merge($content[$binding->modelName()] ?? [], $binds);

            $progress->advance();
        }

        file_put_contents(
            $this->laravel->getCachedBindersPath(),
            '<?php return '.var_export($content, true).';'
        );

        $progress->finish();

        $this->line(PHP_EOL);

        $this->components->success('Cached bindings for '.count($content).' model(s).');

        // if ($this->option('show')) {
        //     // $this->table(['Class', 'Binding'], $this->getBindings());
        // }

        $this->components->info('Bindings cached successfully.');
    }

    /**
     * Get all of the events and listeners configured for the application.
     *
     * @return array<int, \Honed\Binding\Binder>
     */
    protected function getBindings()
    {
        $bindings = [];

        foreach ($this->laravel->getProviders(BindingServiceProvider::class) as $provider) {
            $providerBindings = array_merge_recursive(
                $provider->discoveredBinders(),
                $provider->binders()
            );

            $bindings = \array_merge($bindings, $providerBindings);
        }

        return $bindings;
    }

    /**
     * Get the console command options
     *
     * @return array<int,array<int,mixed>>
     */
    protected function getOptions()
    {
        return [
            ['show', 's', InputOption::VALUE_NONE, 'Show the bindings that are being cached'],
        ];
    }
}
